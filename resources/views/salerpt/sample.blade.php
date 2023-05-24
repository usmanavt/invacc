<!DOCTYPE html>
<html>
<head>
    <style>
        @page { margin: 100px 25px; }
        header { position: fixed; top: -60px; left: 100px; right: 0px; background-color: lightblue; height: 50px; }
        footer{ position: fixed; bottom: 60px; left: 0px; right: 0px; background-color: lightblue; height: 50px; }
        p:last-child { page-break-after: never; }
        table {
         border-collapse: collapse; */
        }

        .info{
        float: right;
        border: 1px solid black;
        width: 40%;
        margin-bottom: 20px;
        }

        .customers{
        }

        tr, td{
            border: 1px solid greenyellow;
        }

        .company-name{
            font-size: 40px;
        }

        .items {
            width: 100%;
            padding-top: 20px;
            border: 2px solid black;
        }

        .items td{
            text-align: center;
        }

        .company-info{

        }
        .firstline th{
            border: 0;
        }
        .footer {
            width: 100%;
            border: 0;
            bottom: 0px;
        }
        .global.footer {
            position: fixed;
            width: 100%;
            border: 0;
            bottom: 0;
        }
        .footer th {
                border: 0;
        }

        .header td {
            text-decoration: underline;
        }

        p {
            line-height: 0.5;
        }

    </style>
</head>

<body>

    <img src="https://i.imgur.com/y6SBqHe.jpg" class="logo">

    <p id="company-name" class="company-name">CENSORED</p>

    <div class="info">
        {{ $data[0]->custname }}
        {{ $data[0]->address2 }}
    </div>

    <div class="company-info">
        <p>CENSORED26</p>
        <p>CENSORED</p>
        <p>CENSORED</p>
        <p>CENSORED</p>
    </div>
    <table class="items">
        <tr id="firstline" class="firstline">
            <th id="invoicenumber">Factuur nr: {{ $data[0]->billno }}</th>
            <th></th>
            <th></th>
            <th></th>
            <th id="date">Datum:</th>

        </tr>
        <thead>
            <tr id="0" class="header">
                <td>Artikel</td>
                <td>Beschrijving</td>
                <td>Aantal</td>
                <td>Eenheidpr</td>
                <td>Bedrag</td>
            </tr>
        </thead>
        <tbody>
            {{-- @forelse(json_decode($invoice->itemsjson) as $item)
            <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->description}}</td>
                    <td>{{$item->amount}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->totalPrice}}</td>
            </tr>
            @empty
            <p>geen invoices gevonden</p>
            @endforelse --}}

            @for ($i = 0 ; $i < count($data) ; $i++)
            <tr>

                {{-- {{ $vnvlues += $data[$i]->value }}
                {{ $vsvlues += $data[$i]->staxamount }}
                {{ $vtvlues += $data[$i]->trcvblamount }} --}}


                {{-- <td class="" width="3%">{{ $i+1 }}</td> --}}
                <td  width="3%" style="font-size:0.8rem;text-align:center">{{ $i+1 }}</td>
                <td  width="10%" style="font-size:0.8rem;text-align:right">{{ number_format($data[$i]->qty,0) }}</td>
                <td  width="30%" style="font-size:0.8rem;text-align:left">{{ $data[$i]->material_title }}</td>
                <td  width="10%" style="font-size:0.8rem;text-align:right">{{ number_format($data[$i]->price,1) }}</td>
                <td  width="10%" style="font-size:0.8rem;text-align:right">{{ number_format($data[$i]->value,0) }}</td>
                <td  width="9%" style="font-size:0.8rem;text-align:right">{{ number_format($data[$i]->saletaxper,1) }}</td>
                <td  width="9%" style="font-size:0.8rem;text-align:right">{{ number_format($data[$i]->staxamount,0) }}</td>
                <td  width="8%" style="font-size:0.8rem;text-align:right">0</td>
                <td  width="11%" style="font-size:0.8rem;text-align:right">{{ number_format($data[$i]->trcvblamount,0) }}</td>


            </tr>
            @endfor







        </tbody>
        <tfoot class="global-footer">
            <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Totaal:</td>
                    <td>5000</td>
            </tr>

            <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>BTW 21%</td>
                    <td>214 </td>
            </tr>

            <tr>
                    <td></td>
                    <td>Betalingsvoorwaarden: 30 dagen</td>
                    <td></td>
                    <td>Totaal incl</td>
                    <td>541</td>
            </tr>
        </tfoot>
    </table>

    <table class="footer">
        <tr>
            <th>CENSORED</th>
            <th>CENSORED</th>
            <th>CENSORED</th>
        </tr>
    </table>
</body>

</html>


