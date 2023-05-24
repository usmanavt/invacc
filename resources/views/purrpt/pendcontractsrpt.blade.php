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
                    <span style="font-size:2rem;font-weight: bold">Pending Contracts Items List</span>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Ledger Info --}}
    {{-- <table class="ledger">
        <tbody> --}}
            {{-- <tr>
                <td>
                    Ledger Type
                </td>
                <td>

                    Transaction Prove List (TPL)
                </td>
            </tr> --}}
            {{-- <tr>
                <td>
                    Date Period
                </td>
                <td> --}}
                    {{-- From {{ $fromdate }} to {{ $todate }} --}}
                {{-- </td>
            </tr>
        </tbody>
    </table> --}}

    {{-- column headers --}}
    <table class="column-headers">
        <thead>
            <tr>
                <th class="" width="3%">S#</th>
                <th class="" width="5%">Contract ID</th>
                <th class="" width="10%">Invoice Date</th>
                <th class="" width="8%">Invoice No</th>
                <th class="" width="45%">Material Name</th>
                <th class="" width="3%">Unit</th>
                <th class="" width="8%">Contract Qty</th>
                <th class="" width="8%">Received Qty</th>
                <th class="" width="8%">Pending Qty</th>



            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{ $varcontqty = 0}}
            {{ $varpurqty = 0 }}
            {{ $varbalqty = 0 }}
            {{ $varxyz = 0 }}
            {{-- {{ $creditusd = 0 }} --}}

            @for ($i = 0 ; $i < count($data) ; $i++)
            <tr>

                {{ $varcontqty += $data[$i]->contractqty }}
                {{ $varpurqty += $data[$i]->purqty }}
                {{ $varbalqty += $data[$i]->balqty }}
                {{ $varxyz += 1 }}




                <td class="" width="3%">{{ $i+1 }}</td>
                <td class="" width="5%">{{ $data[$i]->contract_id }} </td>
                <td class="" width="10%">{{ $data[$i]->invoicedate }} </td>
                <td class="" width="10%">{{ $data[$i]->invoiceno }} </td>
                <td class="" width="43%">{{ $data[$i]->mattitle }} </td>
                <td class="" width="5%">{{ $data[$i]->unit }} </td>
                <td class="" width="8%">{{ number_format($data[$i]->contractqty,0) }} </td>
                <td class="" width="8%">{{ number_format($data[$i]->purqty,0) }} </td>
                <td class="" width="8%">{{ number_format($data[$i]->balqty,0) }} </td>
                {{-- <td class="" width="20%">{{ number_format($data[$i]->DebitAmtDlr,2) }}  : {{($data[$i]->cur) }}</td> --}}
                {{-- <td class="" width="20%">{{ number_format($data[$i]->CreditAmtDlr,2) }} : {{($data[$i]->cur) }}<br></td> --}}

            </tr>

            {{-- if({{ $data[$i]->contract_id }})=2
            {
                <tr>
                <td colspan="5" width="43%" style="text-align: right;border-bottom: 1px solid lightgray;"> Total</td>
                </tr>
            } --}}



            @endfor
            <tr>
                <td colspan="5" width="43%" style="text-align: right;border-bottom: 1px solid lightgray;"> Total</td>
                <td colspan="2" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($varcontqty,0) }} </td>
                <td class="3" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($varpurqty,2) }} </td>
                <td class="1" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($varbalqty,2) }} </td>

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
