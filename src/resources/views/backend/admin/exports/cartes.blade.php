
<table>
    <thead>
    <tr>
        <th>Type</th>
        <th>Carte</th>
        <th>Groupe (facultatif)</th>
    </tr>
    </thead>
    <tbody>
        @foreach( $cartes as $carte)
            <tr>
                <td> {{ $carte->type }}</td>
                <td> {{ $carte->carte }}</td>
                <td> {{ $carte->groupe }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
