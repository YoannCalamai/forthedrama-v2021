





<!doctype html>
<head>
    <title>{{$jeu->jeu}}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
    <style>

        @page { margin: 0 }
        body { margin: 0 }
        .sheet {
            margin: 0;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            overflow: hidden;
            page-break-after: always;
        }

        /** Paper sizes **/
        body.A3           .sheet { width: 297mm; height: 419mm }
        body.A3.landscape .sheet { width: 420mm; height: 296mm }
        body.A4           .sheet { width: 210mm; height: 296mm }
        body.A4.landscape .sheet { width: 297mm; height: 209mm }
        body.A5           .sheet { width: 148mm; height: 209mm }
        body.A5.landscape .sheet { width: 210mm; height: 147mm }

        /** Padding area **/
        .sheet.padding-10mm { padding: 10mm }
        .sheet.padding-15mm { padding: 15mm }
        .sheet.padding-20mm { padding: 20mm }
        .sheet.padding-25mm { padding: 25mm }

        /** For screen preview **/
        @media screen {
            body { background: #e0e0e0 }
            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0,0,0,.3);
                margin: 5mm;
            }
        }

        /** Fix for Chrome issue #273306 **/
        @media print {
            body.A3.landscape { width: 420mm }
            body.A3, body.A4.landscape { width: 297mm }
            body.A4, body.A5.landscape { width: 210mm }
            body.A5                    { width: 148mm }
        }



        .flex-c {
            width:100%;
            margin-top: 10mm;
            margin-bottom: 10mm;
            margin-left : 16mm;
            margin-right: 16mm;
        }


        .flex-c:after {
            content: '';
            display: table;
            clear: both;
            page-break-after: always;

        }

        .flex-i {
            height: 150px;
            width: 200px;
            border: 1px solid gray;
            /*margin: 0 10px 10px 0;*/
            margin: 0px;
            float: left;
            padding: 10px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            font-size: 12px;
        }

        .big{
            height: 70%;
            width: 80%;
        }

    </style>
</head>
<body class="A4 landscape">

<?php $compteur_instruction = 1; ?>
<?php $compteur_carte = 1; ?>
<section class="sheet padding-10mm">
    <div class="flex-c">
        @foreach( $jeu->cartes as $carte )

            <div class="flex-i">

                @if( $carte->type == 'instruction') {{ $compteur_instruction }}  <?php $compteur_instruction++ ?> <br /><br /> @endif

                {!! preg_replace('#(<a.*?>).*?(</a>)#', '$1$2', $carte->carte)  !!}

            </div>

            <?php $compteur_carte++ ?>
            <?php if( $compteur_carte % 17 == 0  ){ $compteur_carte = 1; ?>
    </div>
</section>
<section class="sheet padding-10mm">
    <div class="flex-c">
        <?php }?>

        @endforeach

    </div>
</section>
</body>
