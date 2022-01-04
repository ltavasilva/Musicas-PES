@extends('layouts.master')

@section('title', "$title")

@section('customHead')
        <meta name="csrf-token" content="{{ Session::token() }}">
        <style>
            @font-face{
                font-family: MuseoSans700;
                src: url({{asset("asset/Fonts/Museo700-Regular.otf")}}) format('opentype');
                font-weigth:normal;
                font-style:normal;
            }
            .btn-group{
                margin-right: 5px;
                margin-bottom: 5px;
            }
            .btn-xs{padding: 0.05rem 0.2rem; font-size: 0.675rem;}
            #categoriasSel{margin-bottom: 15px; min-height: 38px;}
            .listResultVaga{height: 201px;}
            .last{height: 100px;}
        </style>
        <script src="{{asset('asset/tinymce.min.js')}}" referrerpolicy="origin"></script>
@endsection

@section('content')
		<div class="container">
            <a href="{{url("musicas")}}" class="btn btn-secondary btn-sm">Lista das músicas </a>
            @if ($submit)
            <button type="button" aria-label="Add" class="btn btn-primary btn-sm" data-bs-toggle="modal"
    					data-bs-target="#modalGetVagalume">Importar música do site Vagalume </button>
                        <hr>
            @endif
    				<!-- Modal -->
    				<div class="modal fade" id="modalGetVagalume" tabindex="-1"
    					aria-labelledby="modalLabel" aria-hidden="true">
    					<div class="modal-dialog">
    						<div class="modal-content">
    							<div class="modal-header">
    								<h5 class="modal-title" id="modalLabel">Informe os dados da música</h5>
    								<button type="button" class="btn-close" data-bs-dismiss="modal"
    									aria-label="Close"></button>
    							</div>
    							<div class="modal-body">
    								<form>
                                        <div class="form-check">
                                            <input class="modoVaga form-check-input" type="radio" name="typeVaga" id="rbByName" checked>
                                            <label class="form-check-label" for="rbByName">
                                                Pesquisar pelo nome da música
                                            </label>
                                        </div>
                                            <div class="form-check">
                                            <input class="modoVaga form-check-input" type="radio" name="typeVaga" id="rbByNomeAutor">
                                            <label class="form-check-label" for="rbByNomeAutor">
                                                Pesquisar pelo nome e autor da música
                                            </label>
                                        </div>
        
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
                                            <label id="vagaNomeLabel" for="vagaNome" class="form-label">Nome da música</label> 
                                            <input type="text" id="vagaNome" class="form-control" placeholder="Nome da música">
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6 vagaAutor" style="display: none;">
                                            <label id="vagaAutorLabel" for="vagaAutor" class="form-label">Autor da música</label> 
                                            <input type="text" id="vagaAutor" class="form-control" placeholder="Autor da música">
                                        </div>
                                        <div class="alert alert-danger notFound" style="display: none;">
                                            Desculpe, nada foi encontrado!
                                        </div>
                                    </form>


                                    <div class="resultVaga hide">
                                        <div class="label">
                                            Músicas encontradas, selecione uma ou faça nova pesquisa.
                                        </div>
                                        <div class="list-group overflow-auto listResultVaga">

                                        </div>
                                    </div>
    							</div>

    							<div class="modal-footer">
    								<button type="button" class="btn btn-secondary"
    									data-bs-dismiss="modal">Cancelar</button>
    								<button id="btnPesquisarVagalume" type="button" class="btn btn-primary">Perquisar</button>
    							</div>
    						</div>
    					</div>
    				</div>

    		<div class="row"> 
                @if ($submit)
                <div id="buttonGrp" class="col-12 col-sm-12 col-md-7 col-lg-5 col-xl-4 col-xxl-4">
                    <div id="categoriaTemplate" class="hide">
                        <div class="btn-group btn-group-sm {{($editing == true || $submit == true) ? 'btn-label' : ''}} template hide" role="group" aria-label="1">
                            <button type="button" class="btn btn-sm btn-secondary">Template</button>
                        </div>
                    </div>

                   
                    <label for="categorias" class="form-label">Insira as categorias desta música:</label> 
                    <div style="display: -webkit-inline-box;">
                        
                        <select id="categorias" class="form-select" style="margin-right: 5px;" aria-label="Selecione a categoria">
                            <option value="" selected>Selecione...</option>
                            @foreach ($categoria as $field=>$value)
                                @if(in_array($value['id'], $categoriaSel))
                                    <option value="{{$value['id']}}" style="display: none;">{{$value['tipo']}}&nbsp-&nbsp{{$value['categoria']}}</option>
                                @else
                                    <option value="{{$value['id']}}">{{$value['tipo']}}&nbsp-&nbsp{{$value['categoria']}}</option>
                                @endif
                            @endforeach
                        </select>
                        <button id="btnAddCateg" type="button" class="btn btn-primary">Add <i data-feather="plus-square" class="feather16"></i></button>
                    </div>
                </div>
                @endif
                <div id="buttonGrp" class="col-12 col-sm-12 col-md-12 {{($submit) ? 'col-lg-7 col-xl-8 col-xxl-8' : ''}}">
                    <label for="categoriasSel" class="form-label">Categorias selecionadas</label>
                    <div class="btn-toolbar form-control" role="toolbar" aria-label="Categorias" id="categoriasSel">
                        @foreach ($categoria as $value)
                            @if(in_array($value['id'], $categoriaSel))
                            <div class="btn-group btn-group-sm {{($editing == true || $submit == true) ? 'btn-label' : ''}}" role="group" aria-label="{{$value['tipo']}}&nbsp-&nbsp{{$value['categoria']}}">
                                <button type="button" class="btn btn-sm btn-secondary" data-id="{{$value['id']}}">{{$value['categoria']}} @if($editing == true || $submit == true)<i data-feather='trash-2' class='feather16'></i>@endif</button>
                            </div>
                            @endif
                        @endforeach
                    </div>
    			</div>
            </div>
            <hr>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    		<form id="formMusica" class="row g-3 col-12 col-sm-12" method="POST" 
            action="{{url($formAction)}}">
            @csrf

            
            @if ($submit)
            <div class="col">
                <button id="btnSubmit" type="submit" class="btn btn-primary">Salvar</button>
            @endif
            @if ($editing)
                @if ($isAdmin)
                <button id="btnDel" type="button" data-id="{{$musica->id}}" class="btn btn-primary">Remover</button>
                @endif
            </div>
            @endif
            @if ($submit || $editing) 
                <hr>
            @endif
            <input type="hidden" id="musicaId" name="id" value="{{$musica->id}}">
            <input type="hidden" id="musicaCategoria" name="musicaCategoria" value="">
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
                    <label for="musicaNome" class="form-label">Nome da música</label> 
                    <input type="text" id="musicaNome" class="form-control" name="nome" placeholder="Nome da música" 
                    value="{{ ($errors->any()) ? old('nome') : $musica->nome }}">
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
                    <label for="musicaAutor" class="form-label">Autor da música</label> 
                    <input type="text" id="musicaAutor" class="form-control" name="autor" placeholder="Autor da música" rows="7" 
                        value="{{ ($errors->any()) ? old('autor') : $musica->autor }}">
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <label for="musicaLetra" class="form-label">Letra da música</label> 
                    <textarea id="musicaLetra" class="form-control" name="letra" 
                        placeholder="Letra da música" rows="10">{{ ($errors->any()) ? old('letra') : $musica->letra }}</textarea>
                </div>
                <div class="grid-row hide">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 editor">
                        <textarea id="musicaSlides" class="form-control" name="slides" rows="10">{{ ($errors->any()) ? old('slides') : $musica->slides }}</textarea>
                    </div>
                </div>
                <div class="last"></div>
            </form>
    	</div>
@endsection

@section('javaScript')
            var parseJS = true;
            var urlVagalume = "https://api.vagalume.com.br/search.excerpt?apikey=f920b3e8cae850c00a7d4026b8d1318f&q=:musica";
            /*var tynyParams = {
                selector: '#musicaSlides',
                plugins: [' advlist anchor autolink codesample fullscreen help image imagetools tinydrive',
                        ' lists link media noneditable preview',
                        ' searchreplace table template visualblocks wordcount pagebreak'],
                skin: 'oxide-dark',
                content_css: 'dark',
                //font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Museo Sans 700=Museo700-Regular; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
                font_formats: "MuseoSans700",
                content_style: "@import url({{asset('asset/tinymce.css')}}); body { font-family: MuseoSans700; font-size:15pt}",
                height: 500,
                toolbar: 'undo redo | pagebreak | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist checklist | searchreplace casechange formatpainter table',
                toolbar_mode: 'floating',
            };
            tinymce.init(tynyParams);*/

            function addCategoria(e){
                var valor = $( "#categorias" ).val();
                var texto = $( "#categorias option:selected" ).text();
                texto = texto.replace("Geral", "").replace("Missa", "").replace("-", "").replace("Missa", "").replace(/\u00A0/g, '');
                if (valor != ""){
                    var categSel = $( "#categoriasSel" );
                    var template = $( "#categoriaTemplate" );

                    template.children("div").children("button").html(texto + " <i data-feather='trash-2' class='feather16'></i>");
                    template.children("div").children("button").attr('data-id', valor);
                    html = categSel.html() + template.html();
                    categSel.html(html);
                    template.hide();
                    categSel.children(".template").removeClass('hide').show();
                    categSel.children(".template").attr('data-categoria', valor);
                    categSel.children(".template").removeClass("template");
                    feather.replace();

                    $("#categorias").prop("selectedIndex", 0);
                    $("#categorias option[value='" + valor + "']").hide();

                    setListener();
                }
            }
            
            $( "#btnAddCateg" ).on("click", function(e){
                addCategoria(e);
            });

            function setListener(){
                $( ".btn-label button" ).on( "click", function(e) {
                    var valor = $(this).data('id'),
                    parent = e.currentTarget.parentElement;
    
                    $(parent).remove();
                    $("#categorias option[value='" + valor + "']").show();
                });
            }

            setListener();

            $( "#formMusica" ).on("submit", function(e){
                var valor = "";
                var sep = "";
                $("#categoriasSel").children().each(function(i, elm) {
                    valor += sep + $(elm).data("categoria");
                    sep = ";";
                });
                $( "#musicaCategoria" ).val(valor);
            });

            $(".modoVaga").on('change', function(e){
                var id = this.id;
                if( id == "rbByNomeAutor"){
                    parseJS = false;
                    $(".vagaAutor").show();
                    urlVagalume = "https://api.vagalume.com.br/search.php?apikey=f920b3e8cae850c00a7d4026b8d1318f&mus=:musica&art=:autor";
                }else{
                    parseJS = true;
                    $(".vagaAutor").hide();
                    urlVagalume = "https://api.vagalume.com.br/search.excerpt?apikey=f920b3e8cae850c00a7d4026b8d1318f&q=:musica";
                }
            });

            function setMusica(e){
                console.log("Aki");
                var nodeName = e.target.nodeName;
                if(nodeName != "BUTTON"){
                    var tipo = $(e.currentTarget).data("type");

                    if(tipo == 'link'){
                        var musicaId = $(e.currentTarget).data("id"),
                            musicaNome = $(".link"+musicaId+" input[name='vagaMusicaNome']").val(),
                            musicaAutor = $(".link"+musicaId+" input[name='vagaMusicaAutor']").val(),
                            musicaLetra = "" + $(".link"+musicaId+" input[name='vagaMusicaLetra']").val();
                            musicaLetraForm = musicaLetra.replaceAll('\n', '<br>');

                        
                        $("#musicaNome").val(musicaNome);
                        $("#musicaAutor").val(musicaAutor);
                        $("#musicaLetra").text(musicaLetra);
                        $("#musicaSlides").text(musicaLetraForm);

                        $("#musicaSlides").show();
                        $(".editor").find('div').first().remove();
                        tinymce.init(tynyParams);

                        $('#modalGetVagalume').modal('hide');
                    }
                }
            };

            $("#btnPesquisarVagalume").on('click', function(e){
                $(".notFound").hide();
                var musica = $("#vagaNome").val();
                var autor = $("#vagaAutor").val();
                var template = '<a href="#" class="vagaMusicaSel list-group-item list-group-item-action list-group-item-primary flex-column align-items-start link:vagaMusicaId" data-type="link" data-id=":vagaMusicaId">';
                    template += '   <div class="d-flex w-100 justify-content-between" data-type="link">';
                    template += '    <h6 class="mb-1" data-type="link">:vagaMusicaNome</h6>';
                    template += '    <small><button type="button" class="getLetra btn btn-secondary btn-xs button:vagaMusicaId" data-type="button" data-id=":vagaMusicaId" data-bs-toggle="tooltip" data-bs-placement="right" title="">ver Letra</button></small>';
                    template += '</div>';
                    template += '<small class="text-muted" data-type="link">:vagaMusicaAutor</small>';
                    template += '<input type="hidden" name="vagaMusicaNome" value=":vagaMusicaNome" /> ';
                    template += '<input type="hidden" name="vagaMusicaAutor" value=":vagaMusicaAutor" /> ';
                    template += '<input type="hidden" name="vagaMusicaUrl" value=":vagaMusicaUrl" /> ';
                    template += '<input type="hidden" id="campo:vagaMusicaId" name="vagaMusicaLetra" value=":vagaMusicaLetra" /> ';
                    template += '</a>';

				var jqxhr = $.get( urlVagalume.replace(':musica', musica).replace(':autor', autor), null, function(response) {
					var lista, musicaId;
                    if (parseJS){
                        response = JSON.parse(response);
                        lista = response.response.docs;

                        $(".resultVaga").removeClass("hide").show();
                        $(".listResultVaga").html("");

                        lista.forEach(function(elm, idx){
                            musicaId = elm.id.substr(1);
                            console.log("https://api.vagalume.com.br/search.php?apikey=f920b3e8cae850c00a7d4026b8d1318f&musid="+musicaId);
                            
                            $(".listResultVaga").append(template
                                .replaceAll(':vagaMusicaNome', elm.title)
                                .replaceAll(':vagaMusicaAutor', elm.band)
                                .replaceAll(':vagaMusicaId', musicaId)
                                .replace(':vagaMusicaUrl', elm.url)
                            );
                            
                            var settings = {
                                'cache': false,
                                'dataType': "jsonp",
                                "async": true,
                                "crossDomain": true,
                                "url": "https://api.vagalume.com.br/search.php?apikey=f920b3e8cae850c00a7d4026b8d1318f&musid="+musicaId,
                                "method": "GET",
                                "headers": {
                                    "accept": "application/json",
                                    "Access-Control-Allow-Origin":"*"
                                }
                            }
                      
                            $.ajax(settings).done(function (response) {
                                var letra = response.mus[0].text;
                                    musicaId = response.mus[0].id;

                                    $("#campo"+musicaId).val(letra);

                                    $(".button"+musicaId).attr('title', letra);     
                                    $(".button"+musicaId).tooltip({trigger: 'click'});
                                    $(".link"+musicaId).on('click', function(e){setMusica(e)});
                            });


                            /*var jqxhr = $.get( "https://api.vagalume.com.br/search.php?apikey=f920b3e8cae850c00a7d4026b8d1318f&musid="+musicaId, null, function(response){})
                                .done(function(response) {
                                    var letra = response.mus[0].text;
                                    musicaId = response.mus[0].id;

                                    $("#campo"+musicaId).val(letra);

                                    $(".button"+musicaId).attr('title', letra);     
                                    $(".button"+musicaId).tooltip({trigger: 'click'});   
                                })
                                .fail(function(response) {
                                    var msg = response.responseJSON.message;
                                    alert("Ohh não, algo deu errado!\n" + msg);
                                })
                                .always(function() {
                                    $(".link"+musicaId).on('click', function(e){setMusica(e)});
                                });*/
                        });
                    }else{
                        lista = response.mus;
                        musicaId = lista[0].id;
                        var letra = response.mus[0].text;

                        $(".resultVaga").removeClass("hide").show();
                        $(".listResultVaga").html("");
                            
                        $(".listResultVaga").append(template
                            .replaceAll(':vagaMusicaNome', lista[0].name)
                            .replaceAll(':vagaMusicaAutor', response.art.name)
                            .replaceAll(':vagaMusicaId', musicaId)
                            .replace(':vagaMusicaUrl', lista[0].url)
                            .replace(':vagaMusicaLetra', letra)
                        );

                        

                        $(".link"+musicaId+" input[name='vagaMusicaLetra']").val(letra);
                        $(".button"+musicaId).attr('title', letra);     
                        $(".button"+musicaId).tooltip({trigger: 'click'});

                        $(".link"+musicaId).on('click', function(e){setMusica(e)});
                    }

                    if(lista.length > 0){
                        
                    }else{
                        $(".notFound").show();
                    }
				})
				.done(function(response) {
					//alert( "Música Excluída com sucesso" );
				})
				.fail(function(response) {
					var msg = response.responseJSON.message;
					alert("Ohh não, algo deu errado!\n" + msg);
				});

            });

            $("#btnDel").on( "click", function(e) {
				if (!confirm("Tem certeza que deseja excluir esta música?\nEsta ação é irreversível!")){
					return false;
				}
				
				var musicaId = $(e.currentTarget).data('id');
				var data = {
					'_token': $('meta[name=csrf-token]').attr('content'),
					id: musicaId,
				};
				var jqxhr = $.post( "{{url("musicas/delete")}}", data, function(response) {
					$(".rowId" + musicaId).remove();
				})
				.done(function(response) {
					alert( "Música Excluída com sucesso" );
                    location.replace("{{url('musicas')}}");
				})
				.fail(function(response) {
					var msg = response.responseJSON.message;
					alert("Ohh não, algo deu errado! A música não pôde ser excluída!\n" + msg);
				});
			});
@endsection