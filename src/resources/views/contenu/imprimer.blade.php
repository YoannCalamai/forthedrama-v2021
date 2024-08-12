






<!doctype html>
<title>Example</title>
<style>
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        grid-gap: 1rem;
        page-break-inside: avoid;
        align-items: center;
        justify-items: center;
        margin-top: 20px;

    }

    .grid > article {
        border: 1px solid #ccc;
        box-shadow: 2px 2px 6px 0px  rgba(0,0,0,0.3);
        max-height:240px;
        min-height:240px;

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
        font-size:12px
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
        <?php if( $compteur_carte % 13 == 0  ){ $compteur_carte = 1; ?>
</main>
<main class="grid">
    <?php }?>

    @endforeach

</main>

