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
                <td align="center" style="width:60%;">
                    <h1>MUHAMMAD NAZIR & Co </h1>
                </td>
                {{-- <td align="right" style="width:20%;"> --}}
                    &nbsp;&nbsp;&nbsp;&nbsp;
                {{-- </td> --}}
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
                    {{-- <h3> {{ $hdng2 }} </h3> --}}
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">BALANCE SHEET </span>
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
                <th class="column-headers" width="28%">HEAD OF ACCOUNTS</th>
                <th class="column-headers" width="13%">AMOUNT</th>
                <th class="column-headers" width="13%"></th>
                <th class="column-headers" width="28%">HEAD OF ACCOUNTS</th>
                <th class="column-headers" width="13%">AMOUNT</th>


            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{-- {{ $debitpkr = 0}} --}}
            {{ $vamount = 0 }};
            {{ $vamount1 = 0 }}
            {{-- {{ $creditusd = 0 }}           {{ $stdebitusd = 0 }};  {{ $stcreditusd = 0 }};  {{ $varval = 0 }} --}}

@for ($i = 0 ; $i < count($data) ; $i++)
{{-- {{ $vamount1 += $data[$i]->amount }} --}}
@if( $i==0 )
                <tr>
                    <td colspan="3"  style="text-align: left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->grp1}}  </td>
                    <td colspan="9"  style="text-align: left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->grp2}}  </td>
                </tr>
            @else
        {{ $srno = $i - 1 }}
        {{ $vamount += $data[$srno]->amount1 }}
        {{-- {{ $stcreditusd += $data[$srno]->CreditAmtDlr }} --}}


        @if ($data[$i]->grpid1  <> $data[$srno]->grpid1)
        {{-- {{ $varval = $stdebitusd - $stcreditusd  }} --}}

            <tr>
                <td colspan="2"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">Sub Total(s)</td>
                <td colspan="1"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($vamount,0) }} </td>
                {{-- <td colspan="1"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stcreditusd,2) }} </td>
                <td colspan="1"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($varval,2) }} </td> --}}

            </tr>
            {{ $vamount = 0 }};
            <tr>
                    <td colspan="5"  style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->grp1}} </td>
             </tr>


        @endif
        @endif


            <tr>

                {{-- {{ $vamount1 += $data[$i]->amount }} --}}
                {{-- {{ $creditusd += $data[$i]->CreditAmtDlr }} --}}




                <td style="text-align: centre"; width="5%">{{ $i+1 }}</td>
                <td style="text-align: left"; width="28%">{{ $data[$i]->title1 }} </td>
                <td style="text-align: right"; width="13%">{{ number_format($data[$i]->amount1,0) }}</td>
                <td style="text-align: left"; width="13%">{{ $data[$i]->gape1 }} </td>
                <td style="text-align: left"; width="28%">{{ $data[$i]->title2 }} </td>
                <td style="text-align: right"; width="13%">{{ number_format($data[$i]->amount2,0) }}</td>


            </tr>
@endfor
<tr>
    <td colspan="2"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">Grand Total(s)</td>
    <td colspan="1"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($vamount1,0) }} </td>
    {{-- <td colspan="1"  style=" border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($creditusd,2) }} </td> --}}

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
