<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AnalyzeSitePerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:analyze-performance 
                            {url? : URL для анализа (по умолчанию берется из APP_URL)}
                            {--mobile : Анализ для мобильных устройств}
                            {--detailed : Подробный анализ с разбивкой по ресурсам}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Анализ производительности сайта: TTFB, размер страницы, количество запросов';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = $this->argument('url') ?? config('app.url');
        $isMobile = $this->option('mobile');
        $detailed = $this->option('detailed');

        $this->info("Анализ производительности: {$url}");
        $this->newLine();

        // Базовый анализ через cURL
        $this->info("📊 Базовый анализ...");
        $basicMetrics = $this->analyzeBasicMetrics($url, $isMobile);
        $this->displayBasicMetrics($basicMetrics);

        // Детальный анализ ресурсов
        if ($detailed) {
            $this->newLine();
            $this->info("📦 Анализ ресурсов...");
            $resources = $this->analyzeResources($url);
            $this->displayResources($resources);
        }

        // Рекомендации
        $this->newLine();
        $this->info("💡 Рекомендации:");
        $this->displayRecommendations($basicMetrics);

        return 0;
    }

    /**
     * Базовый анализ метрик через cURL
     */
    private function analyzeBasicMetrics(string $url, bool $isMobile = false): array
    {
        $ch = curl_init($url);
        
        $userAgent = $isMobile 
            ? 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1'
            : 'Mozilla/5.0 (compatible; PerformanceAnalyzer/1.0)';
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_NOBODY => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_USERAGENT => $userAgent,
            CURLOPT_ENCODING => '', // Поддержка gzip
        ]);

        $startTime = microtime(true);
        $response = curl_exec($ch);
        $endTime = microtime(true);

        $totalTime = ($endTime - $startTime) * 1000; // в миллисекундах
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $ttfb = curl_getinfo($ch, CURLINFO_STARTTRANSFER_TIME) * 1000;
        $connectTime = curl_getinfo($ch, CURLINFO_CONNECT_TIME) * 1000;
        $sizeDownload = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);
        $sizeUpload = curl_getinfo($ch, CURLINFO_SIZE_UPLOAD);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $speedDownload = curl_getinfo($ch, CURLINFO_SPEED_DOWNLOAD);
        
        curl_close($ch);

        $bodySize = strlen($response) - $headerSize;
        $headerSize = $headerSize;

        return [
            'http_code' => $httpCode,
            'total_time' => round($totalTime, 2),
            'ttfb' => round($ttfb, 2),
            'connect_time' => round($connectTime, 2),
            'size_download' => $sizeDownload,
            'size_upload' => $sizeUpload,
            'header_size' => $headerSize,
            'body_size' => $bodySize,
            'content_type' => $contentType,
            'speed_download' => $speedDownload,
            'url' => $url,
        ];
    }

    /**
     * Отображение базовых метрик в таблице
     */
    private function displayBasicMetrics(array $metrics): void
    {
        $this->table(
            ['Метрика', 'Значение', 'Оценка'],
            [
                ['HTTP код', $metrics['http_code'], $this->evaluateHttpCode($metrics['http_code'])],
                ['TTFB (Time to First Byte)', $this->formatTime($metrics['ttfb']), $this->evaluateTtfb($metrics['ttfb'])],
                ['Время подключения', $this->formatTime($metrics['connect_time']), $this->evaluateConnectTime($metrics['connect_time'])],
                ['Общее время загрузки', $this->formatTime($metrics['total_time']), $this->evaluateTotalTime($metrics['total_time'])],
                ['Размер страницы', $this->formatBytes($metrics['body_size']), $this->evaluateSize($metrics['body_size'])],
                ['Размер заголовков', $this->formatBytes($metrics['header_size']), ''],
                ['Скорость загрузки', $this->formatBytes($metrics['speed_download']) . '/s', ''],
            ]
        );
    }

    /**
     * Анализ ресурсов на странице
     */
    private function analyzeResources(string $url): array
    {
        // Простой парсинг HTML для поиска ресурсов
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; PerformanceAnalyzer/1.0)',
            CURLOPT_ENCODING => '',
        ]);
        $html = curl_exec($ch);
        curl_close($ch);

        if (!$html) {
            return [
                'css' => [],
                'js' => [],
                'images' => [],
                'fonts' => [],
            ];
        }

        $resources = [
            'css' => [],
            'js' => [],
            'images' => [],
            'fonts' => [],
        ];

        // Поиск CSS
        preg_match_all('/<link[^>]+href=["\']([^"\']+\.css[^"\']*)["\'][^>]*>/i', $html, $cssMatches);
        if (!empty($cssMatches[1])) {
            $resources['css'] = array_unique($cssMatches[1]);
        }

        // Поиск JS
        preg_match_all('/<script[^>]+src=["\']([^"\']+\.js[^"\']*)["\'][^>]*>/i', $html, $jsMatches);
        if (!empty($jsMatches[1])) {
            $resources['js'] = array_unique($jsMatches[1]);
        }

        // Поиск изображений
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $html, $imgMatches);
        if (!empty($imgMatches[1])) {
            $resources['images'] = array_unique($imgMatches[1]);
        }

        // Поиск шрифтов
        preg_match_all('/<link[^>]+href=["\']([^"\']+\.(woff|woff2|ttf|otf)[^"\']*)["\'][^>]*>/i', $html, $fontMatches);
        if (!empty($fontMatches[1])) {
            $resources['fonts'] = array_unique($fontMatches[1]);
        }

        return $resources;
    }

    /**
     * Отображение информации о ресурсах
     */
    private function displayResources(array $resources): void
    {
        $this->info("CSS файлы: " . count($resources['css']));
        if ($this->option('detailed') && !empty($resources['css'])) {
            foreach ($resources['css'] as $css) {
                $this->line("  - {$css}");
            }
        }

        $this->info("JavaScript файлы: " . count($resources['js']));
        if ($this->option('detailed') && !empty($resources['js'])) {
            foreach ($resources['js'] as $js) {
                $this->line("  - {$js}");
            }
        }

        $this->info("Изображения: " . count($resources['images']));
        if ($this->option('detailed') && count($resources['images']) > 0 && count($resources['images']) <= 10) {
            foreach (array_slice($resources['images'], 0, 10) as $img) {
                $this->line("  - {$img}");
            }
            if (count($resources['images']) > 10) {
                $this->line("  ... и еще " . (count($resources['images']) - 10) . " изображений");
            }
        }

        $this->info("Шрифты: " . count($resources['fonts']));
        if ($this->option('detailed') && !empty($resources['fonts'])) {
            foreach ($resources['fonts'] as $font) {
                $this->line("  - {$font}");
            }
        }
    }

    /**
     * Отображение рекомендаций по оптимизации
     */
    private function displayRecommendations(array $metrics): void
    {
        $recommendations = [];

        if ($metrics['ttfb'] > 600) {
            $recommendations[] = "⚠️  TTFB слишком высокий ({$this->formatTime($metrics['ttfb'])}). Проверьте сервер, кеширование и оптимизацию базы данных.";
        }

        if ($metrics['body_size'] > 1024 * 1024) {
            $recommendations[] = "⚠️  Размер страницы большой ({$this->formatBytes($metrics['body_size'])}). Оптимизируйте контент, используйте сжатие gzip/brotli.";
        }

        if ($metrics['total_time'] > 3000) {
            $recommendations[] = "⚠️  Время загрузки слишком долгое ({$this->formatTime($metrics['total_time'])}). Проверьте оптимизацию ресурсов и сервера.";
        }

        if ($metrics['connect_time'] > 300) {
            $recommendations[] = "⚠️  Время подключения высокое ({$this->formatTime($metrics['connect_time'])}). Проверьте сетевые настройки и CDN.";
        }

        if (empty($recommendations)) {
            $this->info("✅ Все метрики в норме!");
        } else {
            foreach ($recommendations as $rec) {
                $this->line($rec);
            }
        }
    }

    /**
     * Форматирование времени
     */
    private function formatTime(float $ms): string
    {
        if ($ms < 1000) {
            return number_format($ms, 2) . ' мс';
        }
        return number_format($ms / 1000, 2) . ' с';
    }

    /**
     * Форматирование размера
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Оценка HTTP кода
     */
    private function evaluateHttpCode(int $code): string
    {
        if ($code >= 200 && $code < 300) {
            return '✅ OK';
        } elseif ($code >= 300 && $code < 400) {
            return '⚠️  Redirect';
        } else {
            return '❌ Error';
        }
    }

    /**
     * Оценка TTFB
     */
    private function evaluateTtfb(float $ttfb): string
    {
        if ($ttfb < 200) return '✅ Отлично';
        if ($ttfb < 500) return '⚠️  Хорошо';
        if ($ttfb < 800) return '⚠️  Нужно улучшить';
        return '❌ Плохо';
    }

    /**
     * Оценка времени подключения
     */
    private function evaluateConnectTime(float $time): string
    {
        if ($time < 100) return '✅ Отлично';
        if ($time < 300) return '⚠️  Хорошо';
        return '❌ Плохо';
    }

    /**
     * Оценка общего времени загрузки
     */
    private function evaluateTotalTime(float $time): string
    {
        if ($time < 1000) return '✅ Отлично';
        if ($time < 2000) return '⚠️  Хорошо';
        if ($time < 3000) return '⚠️  Нужно улучшить';
        return '❌ Плохо';
    }

    /**
     * Оценка размера страницы
     */
    private function evaluateSize(int $size): string
    {
        $sizeMB = $size / (1024 * 1024);
        if ($sizeMB < 1) return '✅ Отлично';
        if ($sizeMB < 2) return '⚠️  Хорошо';
        if ($sizeMB < 3) return '⚠️  Нужно улучшить';
        return '❌ Плохо';
    }
}
