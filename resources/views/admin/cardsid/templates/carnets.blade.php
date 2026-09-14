<!DOCTYPE html>
<html lang="es">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <title>Carnet</title>
        

<style>
@font-face {
    font-family: 'DejaVuSans';
    font-style: normal;
    font-weight: normal;
    src: url({{ asset('fonts/DejaVuSans.ttf') }}) format('truetype');
}
body {
    font-family: 'DejaVuSans', sans-serif;
}

        .text-rigth{
            text-align: right;
        }
        .text-center{
            text-align: center;
        }
        .number-fact{
            font-size: 16px;
        }
        .row{
            display: flex;
            flex-wrap: wrap;
        }
        .d-flex {
            display: flex!important;
        }
        .col1{
            flex: 0 0 auto;
            width: 100%;
        }
        .col2{
            flex: 0 0 auto;
            width: 50%;
        }
        .info-header{
            width: 100%;
            font-family: arial;
            font-size: 14px;
        }
        .border-bottom1{
            border-bottom: solid 1px #acacac;
        }
        .b-r{
            border-right: solid 1px #acacac;
            width: 49.7% !important;
        }
        .p-15{
            padding: 15px;
        }
        table.items{
            width: 100%;
        }
        table.items, table.items th, table.items td {
        border: 1px solid #bdb9b9;
        border-collapse: collapse;
        }

.carcontent{    
    width: 216px;
    height: 333px;
    background: #fff;
    display: inline-block;
    margin: 7px;

}

.photo{
    width: 111px;
    height: 150px;
    margin-left: 54px;
    margin-top: 77px;
}
.group{
    padding: 0px;
    margin: 0px;
    text-align: center;
    font-size: 11px;
    font-weight: bold;
    color:#000000;
    font-family:'Arial';
}
.name{
    padding: 0;
    margin: 0;
    text-align: center;
    font-size: 11px;
    font-family: 'Arial';
    margin-bottom: 2px;
    color: #000000;
    padding-top: 3px;
}
.qr{
    margin-left: 10px;
    position: absolute;
    bottom: 10px;
}
.text-light{
    margin: 0px;
    padding: 0px;
    text-align: center;
    font-size: 9px;
    margin-top: 2px;
    font-weight: 300;
    color:#000000;
}
.marginbooton{
    page-break-before:always;
}

@page {
		margin-top: 2cm;
	}
    </style>
  
  
    </head>
    <body style="background-color: #fff;">
       <div class="row">
           <div class="col-md-12">
                @foreach($empleoyes as $key=>$item)
                        @if($key>=1) 
                            <div style="page-break-after:always;"></div>
                        @endif
                        <div class="carcontent " style="background-image: url('{{ asset('plantillas/CARNET.png') }}');background-size: cover;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                            <div   style="height: 230px;display: block;">
                                <img src="{{ $item->photo }}" class="photo" >
                            </div>
                            
                            <div style="height: 55px;display: block;padding: 0px 20px;">                    
                            <h2 class="name">{{ mb_convert_encoding($item->name, 'UTF-8', 'auto') }} {{ mb_convert_encoding($item->last_name, 'UTF-8', 'auto') }}</h2>
                                <h2 class="text-light">{{ $item->type_document }} {{ $item->document }}</h2>
                                <h2 class="text-light">{{ $item->charge->name }}</h2>
                                <h2 class="text-light">RH {{ $item->rh }}</h2>
                            </div>
                            <div style="height: 54px;display: block;">
                                <div class="col-md-12">                    
                                    <img class="qr" src="data:image/svg+xml;base64,'.{{ $item->qr }}.'"  />
                                    <!--{!! QrCode::size(55)->backgroundColor(255,90,0)->generate('https://techvblogs.com/blog/generate-qr-code-laravel-9') !!}-->
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
       </div>
    </body>
</html>
