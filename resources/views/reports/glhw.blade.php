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
    background: #e3e3e3;
    margin-top:5px;
    margin-bottom:5px;
    border-bottom: 2px double  lightgray;
    border-collapse: collapse;
    text-align: center;
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
                {{-- <td align="left" style="width:20%;"> --}}
                    {{-- <img src="{{ asset('/images/pipesfittings.jpg') }}" width="90"> --}}
                {{-- </td> --}}
                <td style= "text-align:center; width:60%;">
                    <h1>MUHAMMAD NAZIR & Co </h1>
                </td>
                {{-- <td align="right" style="width:20%;"> --}}
                    {{-- &nbsp;&nbsp;&nbsp;&nbsp; --}}
                {{-- </td> --}}
            </tr>
        </tbody>
    </table>

    {{-- Address --}}
    <table>
        <tbody>
            <tr>
                <td  style="text-align: center;">
                    <h3 style="font-size:0.8rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                    <h3 style="font-size:0.8rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3>
                    <h3 style="font-size:0.8rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:1.5rem">GENERAL LEDGER HEADER WISE (GLH) </span>
                </td>
            </tr>

        </tbody>
    </table>


    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Head Name
                </td>
                <td>
                    {{ $data[0]->SupName }}
                </td>
                <td>
                    Head Type
                </td>
                <td>
                    {{ $headtype }}
                </td>
            </tr>
            <tr>
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
                <th class="column-headers" width="5%">S#</th>
                <th class="column-headers" width="10%">Date</th>
                <th class="column-headers" width="33%">Particular</th>
                <th class="column-headers" width="7%">Ref</th>
                <th class="column-headers" width="15%">Debit</th>
                <th class="column-headers" width="15%">Credit</th>
                <th class="column-headers" width="15%">Balance</th>
            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{-- {{ $debitpkr = 0}} --}}
            {{ $debitusd = 0 }}
            {{-- {{ $creditpkr = 0 }} --}}
            {{ $creditusd = 0 }}
            {{-- {{ $balpkr = 0 }} --}}
            {{ $balusd = 0 }}

            @for ($i = 0 ; $i < count($data) ; $i++)
            <tr>
                {{-- {{ $debitpkr += $data[$i]->DebitAmtRup }} --}}
                {{ $debitusd += $data[$i]->DebitAmtDlr }}
                {{-- {{ $creditpkr += $data[$i]->CreditAmtDlr }} --}}
                {{ $creditusd += $data[$i]->CreditAmtRup }}
                {{-- {{ $balpkr += $data[$i]->BalanceAmtRup }} --}}
                {{ $balusd += $data[$i]->BalanceAmtDlr }}

                <td class="" width="5%">{{ $i+1 }}</td>
                <td class="" width="10%">{{ $data[$i]->invoice_date }} </td>
                {{-- <td class="" width="33%">{{ $data[$i]->Descr }}<br> {{ $data[$i]->DESCRIPTION }} </td> --}}
                <td  width="33%"> <span style="font-size:0.8rem;font-weight: bold;color:brown">{{ $data[$i]->Descr }}</span>
                    <br> {{ $data[$i]->DESCRIPTION }} </td>

                <td class="" width="7%">{{ $data[$i]->Ref }} </td>


                {{-- <td class="" width="15%">{{ number_format($data[$i]->DebitAmtRup,2) }} : R<br>{{ number_format($data[$i]->DebitAmtDlr,2) }} : $</td> --}}
                {{-- <td class="" width="15%">{{ number_format($data[$i]->CreditAmtRup,2) }}: R<br>{{ number_format($data[$i]->CreditAmtDlr,2) }} : $</td> --}}
                {{-- <td class="" width="15%">{{ number_format($data[$i]->BalanceAmtRup,2) }}: R<br>{{ number_format($data[$i]->BalanceAmtDlr,2) }} : $</td> --}}

                <td class="" width="15%">{{ number_format($data[$i]->DebitAmtDlr,2) }} : $</td>
                <td class="" width="15%">{{ number_format($data[$i]->CreditAmtDlr,2) }}: $</td>
                <td class="" width="15%">{{ number_format($data[$i]->BalanceAmtDlr,2) }}: $</td>
            </tr>
            @endfor
            {{-- <tr>
                <td colspan="4" width="55%" style="text-align: right;border-bottom: 1px solid lightgray;">Total(s)</td>
                <td class="" width="12%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($debitpkr,2) }} : R<br>{{ number_format($debitusd,2) }} : $</td>
                <td class="" width="12%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($creditpkr,2) }}: R<br>{{ number_format($creditusd,2) }} : $</td>
                <td class="" width="12%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($balpkr,2) }}: R<br>{{ number_format($balusd,2) }} : $</td>
            </tr> --}}

            <tr>
                <td colspan="7" width="100%" style="text-align: right;border-bottom: 1px solid lightgray;"></td>
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
