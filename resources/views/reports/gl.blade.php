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
    border-bottom: 2px double gray;
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
                    <h1>MUHAMMAD HABIB & Co. </h1>
                </td>
                <td align="right" style="width:20%;">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
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
                    <span style="font-size:1.5rem;font-weight: bold">GENERAL LEDGER</span>
                </td>
            </tr>
        </tbody>
    </table>

.    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Ledger Type
                </td>
                <td>
                    {{ $data[0]->Descr }}
                </td>

                <td>
                    Currency:
                </td>
                <td>
                    {{ $data[0]->cur }}
                </td>


            </tr>
            <tr>
                <td>
                    Date Period
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
                <th class="" width="5%">S#</th>
                <th class="" width="10%">Date</th>
                <th class="" width="30%">Particular</th>
                <th class="" width="10%">Ref</th>
                <th class="" width="12%">Debit</th>
                <th class="" width="12%">Credit</th>
                <th class="" width="12%">Balance</th>
            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{-- {{ $debitpkr = 0}} --}}
            {{ $debitusd = 0 }}
            {{-- {{ $credit = 0 }} --}}
            {{ $creditusd = 0 }}
            {{-- {{ $balpkr = 0 }} --}}
            {{ $balusd = 0 }}
            @for ($i = 0 ; $i < count($data) ; $i++)
            <tr>
                {{-- {{ $debitpkr += $data[$i]->DebitAmtRup }} --}}
                {{ $debitusd += $data[$i]->DebitAmtDlr }}
                {{-- {{ $credit += $data[$i]->Credit }} --}}
                {{ $creditusd += $data[$i]->CreditAmtDlr }}
                {{-- {{ $balpkr += $data[$i]->balrup }} --}}
                {{ $balusd += $data[$i]->baldlr }}

                <td class="" width="5%">{{ $i+1 }}</td>
                <td class="" width="10%">{{ $data[$i]->invoice_date }} </td>
                <td class="" width="30%">{{ $data[$i]->SupName }}<br> {{ $data[$i]->Description }} </td>
                <td class="" width="10%">{{ $data[$i]->Ref }} </td>
                <td class="" width="10%">{{ number_format($data[$i]->DebitAmtDlr,0) }}
                    {{-- : {{ $data[$i]->cur }} --}}
                    {{-- <br>{{ number_format($data[$i]->CreditAmtDlr,0) }} {{ $data[$i]->cur }}</td> --}}
                <td class="" width="10%">{{ number_format($data[$i]->CreditAmtDlr,0) }}
                    {{-- : {{ $data[$i]->cur }} --}}
                    {{-- PKR<br>{{ number_format($data[$i]->CreditAmtDlr,0) }} : USD</td> --}}
                <td class="" width="10%">{{ number_format($data[$i]->baldlr,0) }}</td>
                {{-- <td class="" width="10%">{{ number_format($data[$i]->bal,2) }}</td>
                <td class="" width="10%">{{ number_format($data[$i]->bal,2) }}</td> --}}
                {{-- : R<br>{{ number_format($data[$i]->baldlr,0) }} : $ --}}
            </tr>
            @endfor
            <tr>
                <td colspan="4" width="60%" style="text-align: right;border-bottom: 1px solid lightgray;">Total(s)</td>
                <td class="" width="15%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($debitusd,0) }}  </td>
                {{-- <br>{{ number_format($creditusd,0) }} --}}
                <td class="" width="15%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($creditusd,0) }}</td>
                {{-- : PKR<br>{{ number_format($creditusd,0) }} : USD --}}
                {{-- <td class="" width="20%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($balpkr,2) }} : PKR<br>{{ number_format($balusd,2) }} : USD</td> --}}
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
