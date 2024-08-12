<!doctype html>
<title>Example</title>
<style>


    .grid {
        display: grid;
        /*grid-template-columns: repeat(auto-fill, minmax(283px, 50px));*/
        grid-template-columns: 1fr 1fr 1fr;
        grid-template-rows: 1fr 1fr;
        grid-template-areas: ". . ." ". . .";
        grid-gap: 5px;
        page-break-inside: avoid;
        align-items: center;
        justify-items: center;
        margin-top: 20px;

    }

    .grid > article {
        margin: 10px;
        border: 1px solid #ccc;
        box-shadow: 2px 2px 6px 0px  rgba(0,0,0,0.3);
        max-height:333px;
        min-height:333px;
        min-width:238px;
        max-width:238px;
        padding-top: 20px;
        text-align: center;

    }

    .licence{
        margin: 10px;
        clear:both;
        float:left;
        max-height:500px;
        min-height:500px;
        min-width:240px;
        max-width:240px;
        padding-top: 20px;
        text-align: center;

    }

    .grid > article img {
        max-width: 100%;
    }

    .grid > article .text {

    }
    .text {
        padding-left: 20px;
        padding-right: 20px;
        padding-top: 30px;
        font-size:16px
    }
    .text > button {
        background: gray;
        border: 0;
        color: white;
        padding: 10px;
        width: 100%;
    }
    .big{
        font-size: 90px;
    }
</style>




<?php $compteur_instruction = 1; ?>
<?php $compteur_carte = 1; ?>
<main class="grid">
    @foreach( $jeu->cartes as $carte )

        <article>
            <div class="text">
                @if( $carte->type == 'instruction') {{ $compteur_instruction }} <br /><br /> <?php $compteur_instruction++ ?>
                @else <br /><br /><br />
                @endif
                {!! preg_replace('#(<a.*?>).*?(</a>)#', '$1$2', $carte->carte)  !!}
            </div>
        </article>

        <?php $compteur_carte++ ?>
        <?php if( $compteur_carte % 7 == 0  ){ $compteur_carte = 1; ?>
</main>
<main class="grid">
    <?php }?>

    @endforeach

</main>
<main class="grid">
    <article>
        <div class="text big">
            X
        </div>
    </article>

</main>


