<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<style>
* {
    margin:0;
    padding:0;
    font-size:0.8rem;
    font-style: normal;
    box-sizing: border-box;
}
table{
    width:100%;
}
.ledger {
    border:1px solid lightgray;
    padding:12px;
}
.column-headers{
    border:1px solid lightgray;
    border-left: 1px solid lightgray;
    border-right: 1px solid lightgray;
    background: #e3e3e3;
    font-size: 1rem;
    margin-top:5px;
    margin-bottom:5px;
    border-collapse: collapse;

}
.column-headers th{
    text-align: center;
}
.data {
    border-collapse: collapse;
    font-size: 1rem;

}
.data tr td{
    border-left: 1px solid lightgray;
    border-top: 1px solid lightgray;
    text-align: left;
    font-size: 0.8rem;
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
.data tr:last-child{
    border-bottom:solid thin;
}
</style>
</head>
    <body>
{{-- https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages?answertab=votes#tab-top --}}

    {{-- Report Header --}}
    <table>
        <tbody>
            <tr>
                {{-- logo --}}
                <td align="left" style="width:20%;">
                    {{-- <img src="{{ asset('/images/pipesfittings.jpg') }}" width="90"> --}}
                </td>
                <td align="center" style="width:60%;">
                    <h1>MUHAMMAD HABIB & Co. </h1>
                </td>
                <td align="right" style="width:20%;">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </td>
.            </tr>
        </tbody>
    </table>

    {{-- Address --}}
    <table>
        <tbody>
            <tr>
                <td  style="text-align: center;">
                    <h3 style="font-size:0.7rem">Steam Pipes, Pipe Fittings, Flanges, Valves, S.S.Pipes & Tbues</h3>
                    <h3 style="font-size:0.7rem">30 KM, Sunder Stop, Multan Road, Lahore</h3>
                </td>
            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:3rem;font-weight: bold">Contracts</span>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Supplier Name
                </td>
                <td>
                    {{ $data[0]->supname }}
                </td>
                <td>
                    Invoice No
                </td>
                <td>
                    {{ $data[0]->invoiceno }}
                </td>
            </tr>
            <tr>
                <td>
                    Period
                </td>
                <td>
                    From {{ $fromdate }} to {{ $todate }}
                </td>
                <td>
                    Invoice Date
                </td>
                <td>
                    {{ $data[0]->invoice_date }}
                </td>


            </tr>
        </tbody>
    </table>
    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="column-headers" width="4%">S#</th>
                    <th class="column-headers" width="40%">Material Name</th>
                    <th class="column-headers" width="4%">Unit</th>
                    <th class="column-headers" width="10%">Bundle-I</th>
                    <th class="column-headers" width="10%">Bundle-II</th>
                    <th class="column-headers" width="8%">TotPcs</th>
                    <th class="column-headers" width="8%">Weight</th>
                    <th class="column-headers" width="8%">Price</th>
                    <th class="column-headers" width="8%">Value</th>
                {{-- </td> --}}
            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{ $vtotpcs = 0 }}
            {{ $vwt = 0 }}
            {{ $vvlues = 0 }}
            {{-- {{ $pcspbundle2 = 0 }} --}}

            @for ($i = 0 ; $i < count($data) ; $i++)
            <tr>

                {{ $vtotpcs += $data[$i]->totpcs }}
                {{ $vwt += $data[$i]->wt }}
                {{ $vvlues += $data[$i]->vlues }}


                <td style="text-align:center" width="4%">{{ $i+1 }}</td>
                <td style="text-align:left" width="40%">{{ $data[$i]->size }} </td>
                <td style="text-align:center"  width="4%">{{ $data[$i]->unit }} </td>
                <td style="text-align:center"  width="10%">{{ $data[$i]->bundle1 }} </td>
                <td style="text-align:center"  width="10%">{{ $data[$i]->bundle2 }} </td>
                <td style="text-align:right"  width="8%">{{ number_format($data[$i]->totpcs,0) }} </td>
                <td style="text-align:right"  width="8%">{{ number_format($data[$i]->wt,1) }} </td>
                <td style="text-align:right"  width="8%">{{ number_format($data[$i]->price,1) }} </td>
                <td style="text-align:right"  width="8%">{{ number_format($data[$i]->vlues,0) }} </td>
            </tr>
            @endfor
            <tr>
                <td class="column-headers" colspan="2" width="40%" style="text-align: right;font-weight: bold; border-bottom: 1px solid lightgray;">Total</td>
                <td class="column-headers" colspan="4" width="8%" style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vtotpcs,0) }} </td>
                <td class="column-headers" colspan="1" width="8%" style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vwt,0) }} </td>
                <td class="column-headers" colspan="2" width="8%" style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vvlues,0) }} </td>
           </tr>






        </tbody>
    </table>

    {{-- Footer  --}}
    <div style="margin-top:64px;">
        <table >

            <tr style="margin-top:16px;margin-bottom:16px;">
                <td style="width=33%;font-size:80%;text-align:center">
                    --------------------
                </td>

                <td style="width=33%;font-size:80%;text-align:center">
                    --------------------
                </td>
            </tr>
            <tr>
                <td style="width=33%;font-size:80%;text-align:center">
                    Prepared By
                </td>

                <td style="width=33%;font-size:80%;text-align:center">
                    Approved By
                </td>
            </tr>
        </table>
    </div>

    </body>
</html>
