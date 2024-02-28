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
    border:1px solid gray;
    border-collapse: collapse;

    background: #e3e3e3;
    margin-top:5px;
    margin-bottom:5px;
    border-bottom: 1px double black;
}
.column-headers th{
    text-align: center;
}
.data {
    border-collapse: collapse;
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
                    <h1>MUHAMMAD NAZIR & Co </h1>
                </td>
                <td align="right" style="width:20%;">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </td>
.            </tr>
        </tbody>
    </table>



    <table>
        <tbody>
            <tr>
                <td  style="text-align: center;">
                    <h3 style="font-size:0.7rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                    <h3 style="font-size:0.7rem">PLOT NO. E-13, S.I.T.E AREA KARACHI MOBILE NO. 0333-3804744</h3>
                    <h3 style="font-size:0.7rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3>

                </td>

            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">Date Wise Stock Movement Ledger History</span>
                </td>
            </tr>

        <tr>

            <td  style="text-align: center;">
                <span style="font-size:1.5rem;font-weight: bold">{{ $ltype }}</span>
            </td>

        </tr>

        <tr>

            <td  style="text-align: center;">
                <span style="font-size:1.5rem;font-weight: bold">{{ $data[0]->ldesc }}</span>
            </td>

        </tr>






        </tbody>
    </table>
    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Material Name
                </td>
                <td>
                    {{ $data[0]->itemdescr }}
                </td>
                <td>
                    Category
                </td>
                <td>
                    {{ $data[0]->source }}
                </td>
            </tr>
            <tr>
                <td>
                    Dimension
                </td>
                <td>
                    {{ $data[0]->DIMENSION }}
                </td>

                <td>
                    Period
                </td>
                <td>
                    From {{ $fromdate }} to {{ $todate }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- column headers --}}
    <table class="column-headers">
        <thead>
            <tr>
                <th class="column-headers"  width="4%">S#</th>3
                <th class="column-headers"  width="8%">Date</th>
                <th class="column-headers"  width="32%">Particular</th>
                <th class="column-headers"  width="7%">Opening <br> Balance </th>
                <th class="column-headers"  width="7%">Purchase</th>
                <th class="column-headers"  width="7%">Sale</th>
                <th class="column-headers"  width="7%">Purchase <br> Return</th>
                <th class="column-headers"  width="7%">Sale <br> Return</th>
                <th class="column-headers"  width="7%">Godown <br>Received</th>
                <th class="column-headers"  width="7%">Godown <br>Issued</th>
                <th class="column-headers"  width="7%">Closing <br>Balance</th>
            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{-- {{ $debitpkr = 0}} --}}
            {{ $oqty = 0 }}
            {{-- {{ $creditpkr = 0 }} --}}
            {{ $received = 0 }}
            {{-- {{ $balpkr = 0 }} --}}
            {{ $sale = 0 }}

            @for ($i = 0 ; $i < count($data) ; $i++)
            <tr>
                {{-- {{ $debitpkr += $data[$i]->DebitAmtRup }} --}}
                {{ $oqty += $data[$i]->oqty }}
                {{-- {{ $creditpkr += $data[$i]->CreditAmtDlr }} --}}
                {{ $received += $data[$i]->received }}
                {{-- {{ $balpkr += $data[$i]->BalanceAmtRup }} --}}
                {{ $sale += $data[$i]->sale }}

                <td style="text-align:center" width="4%">{{ $i+1 }}</td>
                <td style="text-align:center" width="8%">{{ $data[$i]->tdate }} </td>
                <td class="" width="32%">{{ $data[$i]->Descr }} </td>
                {{-- <td class="" width="7%">{{ $data[$i]->Ref }} </td> --}}
                <td style="text-align:center" width="7%">{{ number_format($data[$i]->oqty,1) }} </td>
                <td style="text-align:center" width="7%">{{ number_format($data[$i]->received,1) }}</td>
                <td style="text-align:center" width="7%">{{ number_format($data[$i]->sale,1) }} </td>
                <td style="text-align:center" width="7%">{{ number_format($data[$i]->purret,1) }} </td>
                <td style="text-align:center" width="7%">{{ number_format($data[$i]->saleret,1) }} </td>

                <td style="text-align:center" width="7%">{{ number_format($data[$i]->gmin,1) }} </td>
                <td style="text-align:center" width="7%">{{ number_format($data[$i]->gmout,1) }} </td>


                <td style="text-align:center;color:brown;font-weight:bold" width="7%">{{ number_format($data[$i]->CB,0) }} </td>

            </tr>
            @endfor
            {{-- <tr>
                <td colspan="4" width="55%" style="text-align: right;border-bottom: 1px solid lightgray;">Total(s)</td>
                <td class="" width="12%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($debitpkr,2) }} : R<br>{{ number_format($debitusd,2) }} : $</td>
                <td class="" width="12%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($creditpkr,2) }}: R<br>{{ number_format($creditusd,2) }} : $</td>
                <td class="" width="12%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($balpkr,2) }}: R<br>{{ number_format($balusd,2) }} : $</td>
            </tr> --}}

            <tr>
                <td colspan="11" width="100%" style="text-align: right;border-bottom: 1px solid lightgray;"></td>
                {{-- <td class="" width="12%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($debitpkr,2) }} : R<br>{{ number_format($debitusd,2) }} : $</td>
                <td class="" width="12%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($creditpkr,2) }}: R<br>{{ number_format($creditusd,2) }} : $</td>
                <td class="" width="12%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($balpkr,2) }}: R<br>{{ number_format($balusd,2) }} : $</td> --}}
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
