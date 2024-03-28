<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<style>
{
    margin:0;
    padding:0;
    font-size:0.8rem;
    font-style: normal;
    box-sizing: border-box;
}
table{
    width:100%;
}
body{
    /* border:1px solid lightgray; */
    padding:30px;
    /* width: 100%; */
}
.ledger,.databox{
    border:1px solid lightgray;

}
.ledger{
    padding:12px;
}
.databox{
    /* height:480px; */
    /* padding-bottom: 8px; */
}
.column-headers{
    /* border-top:1px solid lightgray;
    border-bottom:1px solid lightgray;
    background: #e3e3e3;
    margin-top:5px;
    margin-bottom:5px;
    border-bottom: 2px gray; */
    border:1px solid lightgray;
    border-left: 1px solid lightgray;
    border-right: 1px solid lightgray;
    background: #e3e3e3;
    font-size: 0.9rem;
    margin-top:5px;
    margin-bottom:5px;
    border-collapse: collapse;



}
.column-headers th{
    text-align: center;
}
.data1{
    border:1.5px solid burlywood;
    /* border-collapse: collapse; */
     padding:5px;
}
.data {
    border-collapse: collapse;
}
.data tr td{
    border-left: 1px solid lightgray;
    border-right: 1px solid lightgray;
    border-top: 1px solid lightgray;
    text-align: left;
    font-size: 0.9rem;
    font-style: normal;
}
.data tr td:nth-child(7){
    border-right:1px solid lightgray;

}
.data tr td:nth-child(5),
.data tr td:nth-child(6),
.data tr td:nth-child(7),{
    text-align: right;
}
/* .data tr:last-child{
    border-bottom:solid thin;
} */

/* styles.css */


</style>
</head>
    <body>
{{-- https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages?answertab=votes#tab-top --}}

    {{-- calculate the lenght of data here,if more than 30 lines, we need different strategy to print multiple pages --}}
    @php
        $showlines = 33
    @endphp
    @if ( count($data) <= $showlines )
        {{-- Report Header --}}
        @include('localpurchase.components.purreheader')
        {{-- Databox --}}
        <div class="databox">

            {{-- <table>
                <tbody>
                    <tr>
                        <td  style="text-align: left;">
                            <span style="font-size:1.5rem;font-weight: bold">ITEM COST</span>
                        </td>
                    </tr>
                </tbody>
            </table> --}}

            {{-- column headers --}}
            <table class="column-headers ">
                <thead >

            {{-- <tr>
                <td colspan="2" width="42%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> Description Of Items</td>
                <td colspan="2" width="16%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Quantity</td>
                <td colspan="2" width="20%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Supplier Value($)</td>
            </tr> --}}





                    <tr>
                        {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                            <th class="column-headers" width="5%">S#</th>
                            <th class="column-headers" width="53%">Description Of Items</th>
                            <th class="column-headers" width="12%">Quantity</th>
                            <th class="column-headers" width="6%">Unit</th>
                            {{-- <th class="column-headers" width="19%">ForCustomer</th> --}}
                            <th class="column-headers" width="12%">Rate</th>
                            <th class="column-headers" width="12%">Amount</th>
                            {{-- <th class="column-headers" width="8%">Rate<br>W.Cost</th> --}}
                            {{-- <th class="column-headers" width="9%">Amount<br>W.Cost</th> --}}

                        {{-- </td> --}}
                    </tr>
                </thead>
            </table>


            {{-- Actual Data --}}
            <table class="data" cellspacing="10" style="display:table-cell">
                <tbody>

                    {{ $vwt = 0 }};{{ $vvlues = 0 }}
                    {{ $wcvwt = 0 }};{{ $wcvvlues = 0 }}

                    @for ($i = 0 ; $i < count($data) ; $i++)
                        <tr>

                            {{ $vwt += $data[$i]->purqty }}; {{ $vvlues += $data[$i]->vlues }}
                            {{-- {{ $wcvwt += $data[$i]->perft }}; {{ $wcvvlues += $data[$i]->pricevaluecostsheet }} --}}

                            <td style=" border-top: 1px solid lightgray;  text-align:center" width="5%">{{ $i+1 }}</td>
                            <td style=" border-top: 1px solid lightgray; text-align:left" width="53%">{{ $data[$i]->material_title }} </td>
                            <td style=" border-top: 1px solid lightgray; text-align:right" width="12%">{{ number_format($data[$i]->purqty,1) }} </td>
                            <td style=" border-top: 1px solid lightgray; text-align:center" width="6%">{{ $data[$i]->unit }} </td>
                            {{-- <td style=" border-top: 1px solid lightgray; text-align:center" width="20%">{{ $data[$i]->forcust }} </td> --}}
                            <td style=" border-top: 1px solid lightgray; text-align:right" width="12%">{{ number_format($data[$i]->price,1) }} </td>
                            <td style=" border-top: 1px solid lightgray;text-align:right" width="12%">{{ number_format($data[$i]->vlues,0) }} </td>
                            {{-- <td style=" border-top: 1px solid lightgray;text-align:right" width="8%">{{ number_format($data[$i]->perft,2) }} </td> --}}
                            {{-- <td style=" border-top: 1px solid lightgray;text-align:right" width="9%">{{ number_format($data[$i]->pricevaluecostsheet,0) }} </td> --}}

                        </tr>
                    @endfor

                    @if($i < $showlines)
                        @for ($j = $i ; $j <= $showlines ; $j++)
                        <tr>
                            <td class="" width="3%">&nbsp;</td>
                            <td style="font-size:12px" width="53%">&nbsp;</td>
                            <td style="text-align:center;font-size:12px" width="12%"> </td>
                            <td style="text-align:left;font-size:12px" width="6%"></td>
                            {{-- <td style="font-size:12px" width="20%"></td> --}}
                            <td style="font-size:12px" width="12%"></td>
                            <td style="text-align:right;font-size:12px" width="12%"></td>
                            {{-- <td style="text-align:right;font-size:12px" width="8%"></td> --}}
                            {{-- <td style="text-align:right;font-size:12px" width="9%"></td> --}}
                        </tr>
                        @endfor
                    @endif
                    <tr>
                        <td class="column-headers" colspan="2"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">Total</td>
                        <td class="column-headers" colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vwt,0) }} </td>
                        <td class="column-headers" colspan="3"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vvlues,0) }} </td>
                        {{-- <td class="column-headers" colspan="2"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($wcvvlues,0) }} </td> --}}
                    </tr>

                </tbody>

            </table>

        </div>
        {{-- Footer  --}}
        @include('localpurchase.components.footerlocinv')

    @else
        {{ $vvlues = 0 }}
        {{ $vqty = 0 }}
        @foreach ($data->chunk(45) as $j)
            {{-- Report Header --}}
            @include('localpurchase.components.headerlocinv')

            {{-- Databox --}}
         <div class="databox">

            {{-- <table>
                <tbody>
                    <tr>
                        <td  style="text-align: left;">
                            <span style="font-size:1.5rem;font-weight: bold">ITEM COST</span>
                        </td>
                    </tr>
                </tbody>
            </table> --}}

            {{-- column headers --}}
            <table class="column-headers ">
                <thead >
                    <tr>
                        <th class="" width="4%">S#</th>
                        <th class="" width="40%">Material Name</th>
                        <th class="" width="7%">Unit</th>
                        <th class="" width="20%">Brand</th>
                        <th class="" width="9%">Quantity</th>
                        <th class="" width="9%">Price</th>
                        <th class="" width="11%">Amount</th>
                    </tr>
                </thead>
            </table>

            {{-- Actual Data --}}
            <table class="data" cellspacing="10" style="display:table-cell">
                <tbody>


                    @for ($i = 0 ; $i < count($data) ; $i++)
                        <tr>
                            {{ $vvlues += $data[$i]->saleamnt }}
                            {{ $vqty += $data[$i]->qty }}
                            <td class="" width="4%">{{ $i+1 }}</td>
                            <td style="font-size:12px" width="40%">{{ $data[$i]->matname }} </td>
                            <td style="text-align:center;font-size:12px" width="7%">{{ $data[$i]->UOM }} </td>
                            <td style="text-align:left;font-size:12px" width="20%">{{ $data[$i]->mybrand }} </td>
                            <td style="font-size:12px" width="9%">{{ number_format($data[$i]->qty,1) }} </td>
                            <td style="font-size:12px" width="9%">{{ number_format($data[$i]->price,1) }} </td>
                            <td style="text-align:right;font-size:12px" width="11%">{{ number_format($data[$i]->saleamnt,0) }} </td>
                        </tr>
                    @endfor

                </tbody>

            </table>

        </div>

        @endforeach

        <table>
            <tbody>

                <tr>
                    <td colspan="4" width="100%" style="text-align: right;border-bottom: 1px solid lightgray;font-size:12px;font-weight:bold;">Totals</td>
                    {{-- <td colspan="4" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vtotpcs,0) }} </td> --}}
                    <td class="2" width="9%" style="text-align: right;border-bottom: 1px solid lightgray;font-size:12px;font-weight:bold;">{{ $i }}</td>
                    <td class="2" width="9%" style="text-align: right;border-bottom: 1px solid lightgray;">&nbsp; </td>
                    <td class="2" width="11%" style="text-align: right;border-bottom: 1px solid lightgray;font-size:12px;font-weight:bold;">{{ $i }}</td>
                </tr>
            </tbody>
        </table>


         {{-- Footer  --}}
         @include('localpurchase.components.footerlocinv')


    @endif



    </body>
</html>
