@extends('layouts.master')

@section('title', "$title")

@section('customHead')
        <style>
            @font-face{
                font-family: MuseoSans700;
                src: url({{asset("asset/Fonts/Museo700-Regular.otf")}}) format('opentype');
                font-weigth:normal;
                font-style:normal;
            }
            .editor{margin: 20px}
            .btnFechar{margin-left: 20px}
        </style>
        <script src="{{asset('asset/tinymce.min.js')}}" referrerpolicy="origin"></script>
@endsection

@section('content')
        <button type="button" onclick="window.close()" class="btn btn-primary btnFechar">Fechar</button>
		<div class="editor">
            
			<textarea id="musicaSlides" class="form-control" name="slides" rows="10"></textarea>
    	</div>
@endsection

@section('javaScript')
            var tynyParams = {
                selector: '#musicaSlides',
                plugins: [' advlist anchor autolink codesample fullscreen help image imagetools tinydrive',
                        ' lists link media noneditable preview',
                        ' searchreplace table template visualblocks wordcount pagebreak'],
                skin: 'oxide-dark',
                content_css: 'dark',
                //font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Museo Sans 700=Museo700-Regular; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
                font_formats: "MuseoSans700",
                content_style: "@import url({{asset('asset/tinymce.css')}}); body { font-family: MuseoSans700; font-size:30pt; text-align: center}",
                height: 500,
                toolbar: 'undo redo | pagebreak | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist checklist | searchreplace casechange formatpainter table',
                toolbar_mode: 'floating',
            };
            tinymce.init(tynyParams);
@endsection