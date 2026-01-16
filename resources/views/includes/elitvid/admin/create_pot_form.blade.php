{{-- Форма для создания кашпо --}}
<div class="col-md-12 padding-0">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-3 padding-0">
                        <h3>Материал</h3>
                        <div class="col-md-11 padding-0">
                            <input class="form-control {{$errors->has('material') ? 'danger' : ''}}"
                                   type="text"
                                   name="material" value="{{old('material')}}">
                            @error('material')
                            <div class="text-danger" style="margin-top: 5px;">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 padding-0">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body" id="panel-body">
                <h3 style="margin-bottom: 20px;">Варианты товара</h3>

                @php
                    $oldData = old('data', [['size' => '', 'weight' => '', 'price' => '']]);
                    if (empty($oldData) || !is_array($oldData)) {
                        $oldData = [['size' => '', 'weight' => '', 'price' => '']];
                    }
                @endphp

                <div class="responsive-table">
                    <table class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Размер</th>
                                <th>Вес</th>
                                <th>Цена</th>
                                <th style="width: 80px; text-align: center;">Действия</th>
                            </tr>
                        </thead>
                        <tbody id="variants-tbody">
                            @foreach($oldData as $index => $variant)
                                <tr class="variant-row">
                                    <td>
                                        <input class="form-control {{$errors->has('data.'.$index.'.size') ? 'danger' : ''}}"
                                               type="text"
                                               name="data[{{$index}}][size]"
                                               value="{{ old('data.'.$index.'.size', $variant['size'] ?? '') }}">
                                        @error('data.'.$index.'.size')
                                        <div class="text-danger" style="font-size: 11px; margin-top: 4px;">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input class="form-control {{$errors->has('data.'.$index.'.weight') ? 'danger' : ''}}"
                                               type="text"
                                               name="data[{{$index}}][weight]"
                                               value="{{ old('data.'.$index.'.weight', $variant['weight'] ?? '') }}">
                                        @error('data.'.$index.'.weight')
                                        <div class="text-danger" style="font-size: 11px; margin-top: 4px;">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input class="form-control {{$errors->has('data.'.$index.'.price') ? 'danger' : ''}}"
                                               type="text"
                                               name="data[{{$index}}][price]"
                                               value="{{ old('data.'.$index.'.price', $variant['price'] ?? '') }}">
                                        @error('data.'.$index.'.price')
                                        <div class="text-danger" style="font-size: 11px; margin-top: 4px;">
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </td>
                                    <td style="text-align: center;">
                                        <button type="button"
                                                class="btn btn-danger btn-sm closeButton"
                                                title="Удалить вариант">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 15px;" id="add-variant-container">
                    <button type="button" class="btn btn-success addButton">
                        <span class="fa fa-plus"></span> Добавить вариант
                    </button>
                </div>

                @error('data')
                <div class="text-danger" style="margin-top: 10px; font-size: 13px;">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 padding-0">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-3 padding-0">
                        <h2>Форма</h2>
                        <select class="form-control {{$errors->has('collection') ? 'danger' : ''}}" name="collection" id="">
                            <option {{ $errors->has('collection') ? '' : 'selected' }} disabled>Выберите форму</option>
                            <option {{ old('collection') == 'Square' ? 'selected' : ''}} value="Square">Квадратное кашпо</option>
                            <option {{ old('collection') == 'Round' ? 'selected' : ''}}  value="Round">Круглое кашпо</option>
                            <option {{ old('collection') == 'Rectangular' ? 'selected' : ''}} value="Rectangular">Прямоугольные кашпо</option>
                        </select>
                        @error('collection')
                        <div class="text-danger" style="margin-top: 5px;">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
