<?php $compteur_instruction = 1; ?>
<?php $compteur_carte = 1; ?>
<page size="A4" style=""  layout="landscape">
    @foreach( $jeu->cartes as $carte )

    <div class="col-md-3 carte">
        @if( $carte->type == 'instruction') {{ $compteur_instruction }} <br /> <?php $compteur_instruction++ ?> @endif
        {{ $carte->carte }}
        </div>

    <?php $compteur_carte++ ?>
    <?php if( $compteur_carte % 13 == 0  ){ $compteur_carte = 1; ?>
    </page>
<page size="A4" layout="landscape">
    <?php }?>

    @endforeach
    </page>
<div class="page-break"></div>
</body>