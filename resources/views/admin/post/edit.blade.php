@extends('admin.layouts.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Редактирование поста</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <form action="{{ route('admin.post.update', $post->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <input value="{{ $post->title }}" name="title" type="text" class="form-control"
                                   placeholder="Название поста">
                            @error('title')
                            <div class="text-danger">Это поле обязательно для заполнения</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea id="summernote" name="content">{{ $post->content }}</textarea>
                            @error('content')
                            <div class="text-danger">Это поле обязательно для заполнения</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Добавить превью</label>
                            <div class="w-25">
                                <img src="{{ url('storage/' . $post->preview_image) }}" alt="preview_image" class="w-50 mb-2">
                            </div>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="preview_image"
                                           id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Выберите изображение</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Загрузка</span>
                                </div>
                                <div>
                                    @error('preview_image')
                                    <div class="text-danger">Это поле обязательно для заполнения</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Добавить главное изображение</label>
                            <div class="w-25">
                                <img src="{{ url('storage/' . $post->main_image) }}" alt="preview_image" class="w-50 mb-2">
                            </div>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="main_image"
                                           id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Выберите изображение</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Загрузка</span>
                                </div>
                                <div>
                                    @error('main_image')
                                    <div class="text-danger">Это поле обязательно для заполнения</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label>Выберите категорию</label>
                            <select name="category_id" class="custom-select">
                                @foreach($categories as $category)
                                    <option
                                        {{ $category->id == $post->category_id ? 'selected' : ''  }}
                                        value="{{$category->id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <div class="text-danger">Это поле обязательно для заполнения</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Теги</label>
                            <select name="tag_ids[]" class="select2" multiple="multiple" data-placeholder="Выберите теги" style="width: 100%;">
                                @foreach($tags as $tag)
                                    <option {{ is_array($post->tags->pluck('id')->toArray()) && in_array($tag->id, $post->tags->pluck('id')->toArray() ) ? 'selected' : '' }} value="{{$tag->id}}">{{$tag->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Обновить">
                    </form>

                </div>
                <!-- /.row -->

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
