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
                <td align="left" style="width:20%;">
                    {{-- <img src="{{ asset('/images/pipesfittings.jpg') }}" width="90"> --}}
                </td>
                <td align="center" style="width:60%;">
                    <h1>MUHAMMAD NAZIR & Co </h1>
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
                    <h3 style="font-size:0.7rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                    <h3 style="font-size:0.7rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3>
                    <h3 style="font-size:0.7rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">INVOICE WISE PYAMENT DETAILS </span>
                </td>
            </tr>

        </tbody>
    </table>


.    {{-- Ledger Info --}}
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
                    Source:
                </td>
                <td>
                    {{ $data[0]->src }}
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
                <th class="column-headers" width="4%">S#</th>
                <th class="column-headers" width="10%">Invoice<br>date</th>
                <th class="column-headers" width="10%">Invoice<br>No</th>
                <th class="column-headers" width="26%">Payment<br>Status</th>
                <th class="column-headers" width="10%">Payment<br>Date</th>
                <th class="column-headers" width="10%">Payment<br>Ref.</th>
                <th class="column-headers" width="10%">Payable<br>Amount</th>
                <th class="column-headers" width="10%">Payment<br>Amount</th>
                <th class="column-headers" width="10%">Invoice<br>Balance</th>
            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{ $pble = 0 }}
            {{ $pmnt = 0 }}
            {{ $invbal = 0 }}
            @for ($i = 0 ; $i < count($data) ; $i++)
            <tr>
                {{ $pble += $data[$i]->payable }}
                {{ $pmnt += $data[$i]->payment }}
                {{ $invbal += $data[$i]->invoice_bal }}

                <td style="text-align:center" width="4%">{{ $i+1 }}</td>
                <td style="text-align:center" width="10%">{{ $data[$i]->invoice_date }} </td>
                <td style="text-align:center" width="10%">{{ $data[$i]->invoiceno }} </td>
                <td style="text-align:left" width="26%">{{ $data[$i]->paystatus }} </td>
                <td style="text-align:center" width="10%">{{ $data[$i]->pdate }} </td>
                <td style="text-align:center" width="10%">{{ $data[$i]->ref }} </td>
                <td style="text-align:right" width="10%">{{ number_format($data[$i]->payable,0) }} </td>
                <td style="text-align:right" width="10%">{{ number_format($data[$i]->payment,0) }} </td>
                <td style="text-align:right" width="10%">{{ number_format($data[$i]->invoice_bal,0) }} </td>

            </tr>
            @endfor
            <tr>
                <td colspan="7"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double   lightgray; ">{{ number_format($pble,0) }}</td>
                <td colspan="1"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double   lightgray; ">{{ number_format($pmnt,0) }}</td>
                <td colspan="1"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double   lightgray; ">{{ number_format($invbal,0) }}</td>
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
