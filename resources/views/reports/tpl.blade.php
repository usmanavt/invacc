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
                    <span style="font-size:1.5rem;font-weight: bold">Transaction Prove List</span>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            {{-- <tr>
                <td>
                    Ledger Type
                </td>
                <td>
                    {{ $data[0]->Descr }}
                    Transaction Prove List (TPL)
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
                <th class="column-headers" width="5%">S#</th>
                <th class="column-headers" width="50%">Particular</th>
                <th class="column-headers" width="15%">Debit</th>
                <th class="column-headers" width="15%">Credit</th>
                <th class="column-headers" width="15%">Variance</th>
            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{-- {{ $debitpkr = 0}} --}}
            {{ $debitusd = 0 }}; {{ $creditusd = 0 }}
            {{ $stdebitusd = 0 }};  {{ $stcreditusd = 0 }};  {{ $varval = 0 }}

@for ($i = 0 ; $i < count($data) ; $i++)


@if( $i==0 )

                <tr>
                    <td colspan="6" width="100%" style="text-align: left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Ref}}   -   {{ $data[$i]->invoice_date}} </td>
                </tr>
            @else
        {{ $srno = $i - 1 }}
        {{ $stdebitusd += $data[$srno]->DebitAmtDlr }}
        {{ $stcreditusd += $data[$srno]->CreditAmtDlr }}


        @if ($data[$i]->Ref  <> $data[$srno]->Ref)
        {{ $varval = $stdebitusd - $stcreditusd  }}

            <tr>
                <td colspan="2" width="100%" style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">Sub Total(s)</td>
                <td colspan="1" width="15%" style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stdebitusd,2) }} </td>
                <td colspan="1" width="15%" style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stcreditusd,2) }} </td>
                <td colspan="1" width="15%" style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($varval,2) }} </td>

            </tr>
            <tr>
                    <td colspan="6" width="100%" style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Ref}}   -   {{ $data[$i]->invoice_date}} </td>
             </tr>

             {{ $stdebitusd = 0 }};  {{ $stcreditusd = 0 }}
        @endif
        @endif


            <tr>

                {{ $debitusd += $data[$i]->DebitAmtDlr }}
                {{ $creditusd += $data[$i]->CreditAmtDlr }}





                <td style="text-align:center" width="5%">{{ $i+1 }}</td>
                {{-- <td style="text-align:center" width="10%">{{ $data[$i]->invoice_date }} </td> --}}
                <td  width="50%"> <span style="font-size:0.8rem;font-weight: bold;color:brown">{{ $data[$i]->Descr }}</span>
                    <br> {{ $data[$i]->Description }} </td>
                {{-- <td style="text-align:center" width="10%">{{ $data[$i]->Ref }} </td> --}}
                <td style="text-align:right ;margin-right:10px " width="15%">{{ number_format($data[$i]->DebitAmtDlr,2) }}  : {{($data[$i]->cur) }}</td>
                <td style="text-align:right ;border-right:1px solid lightgray; margin-right:10px ; " width="15%">{{ number_format($data[$i]->CreditAmtDlr,2) }} : {{($data[$i]->cur) }}<br></td>
                <td style="text-align:right ;border-right:1px solid lightgray; margin-right:10px ; " width="15%">0<br></td>

            </tr>
@endfor
<tr>
    <td colspan="2" width="100%" style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">Grand Total(s)</td>
    <td colspan="1" width="15%" style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($debitusd,2) }} </td>
    <td colspan="1" width="15%" style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($creditusd,2) }} </td>

</tr>



</tbody>
    </table>

    {{-- Footer  --}}
    {{-- <div style="margin-top:64px;">
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

    </body> --}}
</html>
