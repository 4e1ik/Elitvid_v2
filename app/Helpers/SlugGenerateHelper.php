<?php

namespace App\Helpers;

final class SlugGenerateHelper
{
    /**
     * Стоп-слова (предлоги, союзы, артикли) — удаляются из slug для краткости и SEO.
     * Латиница: английские и русская транслитерация.
     */
    private const STOP_WORDS = [
        'a', 'an', 'the', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by', 'and', 'or', 'but',
        'is', 'it', 'as', 'be', 'are', 'was', 'were', 'been', 'being', 'have', 'has', 'had',
        'do', 'does', 'did', 'will', 'would', 'could', 'should', 'may', 'might', 'must', 'can',
        'i', 'na', 'v', 'dlya', 's', 'po', 'iz', 'k', 'u', 'o', 'ob', 'ot', 'do', 'za', 'no',
        'ili', 'chto', 'kak', 'so', 'bez', 'pri', 'nad', 'pod', 'mezhdu', 'pred', 'eto',
    ];

    public function slug(string $text): string
    {
        // Удаляем HTML-теги и декодируем entities
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $translitMap = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
            'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
            'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'a', 'Б' => 'b', 'В' => 'v', 'Г' => 'g', 'Д' => 'd', 'Е' => 'e', 'Ё' => 'yo',
            'Ж' => 'zh', 'З' => 'z', 'И' => 'i', 'Й' => 'y', 'К' => 'k', 'Л' => 'l', 'М' => 'm',
            'Н' => 'n', 'О' => 'o', 'П' => 'p', 'Р' => 'r', 'С' => 's', 'Т' => 't', 'У' => 'u',
            'Ф' => 'f', 'Х' => 'h', 'Ц' => 'ts', 'Ч' => 'ch', 'Ш' => 'sh', 'Щ' => 'sch',
            'Ъ' => '', 'Ы' => 'y', 'Ь' => '', 'Э' => 'e', 'Ю' => 'yu', 'Я' => 'ya',
        ];

        $slug = mb_strtolower($text, 'UTF-8');
        $slug = strtr($slug, $translitMap);
        // Только латиница, цифры; разделитель — дефис
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        // Убираем стоп-слова для краткости и SEO
        $slug = $this->removeStopWords($slug);

        return $slug;
    }

    /**
     * Удаляет стоп-слова из slug (слова разделены дефисами).
     */
    private function removeStopWords(string $slug): string
    {
        if ($slug === '') {
            return '';
        }

        $parts = explode('-', $slug);
        $stopWords = array_fill_keys(self::STOP_WORDS, true);
        $filtered = [];

        foreach ($parts as $part) {
            if ($part === '') {
                continue;
            }
            if (!isset($stopWords[$part])) {
                $filtered[] = $part;
            }
        }

        $result = implode('-', $filtered);
        // Убираем повторяющиеся дефисы после удаления слов
        $result = preg_replace('/-+/', '-', $result);

        return trim($result, '-');
    }
}
