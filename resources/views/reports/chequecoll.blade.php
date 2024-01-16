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
                    <h1>{{ $hdng1 }} </h1>
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
                    {{-- <h3 style="font-size:0.7rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3> --}}
                    {{-- <h3 style="font-size:0.7rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3> --}}
                    {{-- <h3 style="font-size:0.7rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3> --}}
                    <h3> {{ $hdng2 }} </h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">CHEQUE TRANSACTION DETAIL </span>
                </td>
            </tr>

        </tbody>
    </table>


.    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            {{-- <tr>
                <td>
                    Customer Name
                </td>
                <td>
                    {{ $data[0]->custname }}
                </td>

                <td>
                    Phone No:
                </td>
                <td>
                    {{ $data[0]->phoneoff }}
                </td>


            </tr> --}}
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
                <th class="column-headers" width="3%">S#</th>
                <th class="column-headers" width="7%">Entry Date</th>
                <th class="column-headers" width="13%">Bank Name</th>
                <th class="column-headers" width="7%">Cheque No</th>
                <th class="column-headers" width="7%">Cheque Date</th>
                <th class="column-headers" width="8%">Main Head</th>
                <th class="column-headers" width="15%">Sub Head</th>
                <th class="column-headers" width="7%">Received</th>
                <th class="column-headers" width="7%">Payment</th>
                <th class="column-headers" width="6%">Remaining<br>Days</th>
                <th class="column-headers" width="6%">Cleared<br>Status</th>
                <th class="column-headers" width="7%">Cleared <br> Date</th>
                <th class="column-headers" width="7%">Cleared<br>Ref.</th>
            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{ $rcvd = 0 }}
            {{ $pmnt = 0 }}
            {{-- {{ $invbal = 0 }} --}}
            @for ($i = 0 ; $i < count($data) ; $i++)
            <tr>
                {{ $rcvd += $data[$i]->received }}
                {{ $pmnt += $data[$i]->payment }}
                {{-- {{ $invbal += $data[$i]->invoice_bal }} --}}

                <td style="text-align:center" width="3%">{{ $i+1 }}</td>
                <td style="text-align:center" width="7%">{{ $data[$i]->documentdate }} </td>
                <td style="text-align:left" width="13%">{{ $data[$i]->bank }} </td>
                <td style="text-align:left" width="7%">{{ $data[$i]->cheque_no }} </td>
                <td style="text-align:center" width="7%">{{ $data[$i]->cheque_date }} </td>
                <td style="text-align:left" width="8%">{{ $data[$i]->mhead }} </td>
                <td style="text-align:left" width="15%">{{ $data[$i]->supname }} </td>
                <td style="text-align:right" width="7%">{{ number_format($data[$i]->received,0) }} </td>
                <td style="text-align:right" width="7%">{{ number_format($data[$i]->payment,0) }} </td>
                <td style="text-align:center" width="6%">{{ $data[$i]->days }} </td>
                @if ($data[$i]->clrid  == 0)
                    <td style="text-align:center;color:red;font-weight: bold" width="6%">{{ $data[$i]->stts }} </td>
                @else
                <td style="text-align:center;color:green;font-weight: bold" width="6%">{{ $data[$i]->stts }} </td>
                @endif

                <td style="text-align:center" width="7%">{{ $data[$i]->clrdate }} </td>
                <td style="text-align:center" width="7%">{{ $data[$i]->ref }} </td>
            </tr>
            @endfor
            <tr>
                {{-- <td colspan="4"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;"> Total(s)</td> --}}
                {{-- <td colspan="7"  style=" border:1px solid lightgray;. text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double   lightgray; ">{{ number_format($pble,0) }}  </td> --}}
                <td colspan="8"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double   lightgray; ">{{ number_format($rcvd,0) }}</td>
                <td colspan="1"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double   lightgray; ">{{ number_format($pmnt,0) }}</td>
                <td colspan="4"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double   lightgray; "></td>
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
