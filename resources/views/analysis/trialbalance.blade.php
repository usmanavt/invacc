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
    font-size: 0.8rem;
    color: brown;
    font-weight: bold;

}
.data {
    border-collapse: collapse;
}
.data tr td{
    border-left: 1px solid lightgray;
    border-top: 1px solid lightgray;
    text-align: left;
    font-size: 1.5rem;
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
                    {{-- <h1>{{ $hdng1 }} </h1> --}}
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
                    {{-- <h3> {{ $hdng2 }} </h3> --}}
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem;font-weight: bold">TRIAL BALANCE </span>
                </td>
            </tr>

        </tbody>
    </table>


    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            {{-- <tr>
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
            </tr> --}}
            <tr>
                <td>
                    Period
                </td>
                <td>
                    From {{ $fromdate }} to {{ $todate }}
                </td>
                {{-- <td>
                    Up To Date:
                </td>
                <td>
                    {{ $data[0]->mheadname }}
                </td> --}}
            </tr>
        </tbody>
    </table>

    {{-- column headers --}}
    <table class="column-headers">
        <thead>

            <tr>
                <td colspan="2" width="28%" style="font-size: 0.8rem;;text-align:center;font-weight: bold;border-right: 1px solid lightgray;">HEAD OF ACCOUNTS</td>
                <td colspan="2" width="24%" style="font-size: 0.8rem;;text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> OPENING</td>
                <td colspan="2" width="24%" style="font-size: 0.8rem;;text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> ACTIVITY</td>
                <td colspan="2" width="24%" style="font-size: 0.8rem;;text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> CLOSING</td>

            </tr>








            <tr>
                <th class="column-headers" width="3%">S#</th>
                <th class="column-headers" width="25%">PARTICULARS</th>
                <th class="column-headers" width="12%">DEBIT</th>
                <th class="column-headers" width="12%">CREDIT</th>
                <th class="column-headers" width="12%">DEBIT</th>
                <th class="column-headers" width="12%">CREDIT</th>
                <th class="column-headers" width="12%">DEBIT</th>
                <th class="column-headers" width="12%">CREDIT</th>
            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{ $vodebit = 0 }};{{ $vocredit = 0 }}
            {{ $vadebit = 0 }};{{ $vacredit = 0 }}
            {{ $vcdebit = 0 }};{{ $vccredit = 0 }}

            @for ($i = 0 ; $i < count($data) ; $i++)


            @if( $i==0 )
            <tr>
                <td colspan="8"  style=" color:darkorange;font-weight: bold ;text-align: left;font-size:0.9rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->grp}}  </td>
            </tr>
        @else
        {{ $srno = $i - 1 }}

    @if ($data[$i]->grpid  <> $data[$srno]->grpid)
        <tr>
                <td colspan="8"  style="color:darkorange;font-weight: bold ;text-align:left;font-size:0.9rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->grp}} </td>
         </tr>


    @endif
    @endif

























            <tr>
                {{ $vodebit += $data[$i]->odebit }}; {{ $vocredit += $data[$i]->ocredit }}
                {{ $vadebit += $data[$i]->adebit }}; {{ $vacredit += $data[$i]->acredit }}
                {{ $vcdebit += $data[$i]->cdebit }}; {{ $vccredit += $data[$i]->ccredit }}


                <td style="font-size: 0.8rem;text-align: centre"; width="3%">{{ $i+1 }}</td>
                <td style="font-size: 0.8rem;text-align: left"; width="25%">{{ $data[$i]->title }} </td>
                <td style="font-size: 0.8rem;text-align: right"; width="12%">{{ number_format($data[$i]->odebit,0) }}</td>
                <td style="font-size: 0.8rem;text-align: right"; width="12%">{{ number_format($data[$i]->ocredit,0) }}</td>
                <td style="font-size: 0.8rem;text-align: right"; width="12%">{{ number_format($data[$i]->adebit,0) }}</td>
                <td style="font-size: 0.8rem;text-align: right"; width="12%">{{ number_format($data[$i]->acredit,0) }}</td>
                <td style="font-size: 0.8rem;text-align: right"; width="12%">{{ number_format($data[$i]->cdebit,0) }}</td>
                <td style="font-size: 0.8rem;text-align: right"; width="12%">{{ number_format($data[$i]->ccredit,0) }}</td>

            </tr>
            @endfor

            <tr>
                <td colspan="2"  style="font-size: 0.8rem;text-align: right;border-bottom: 1px solid lightgray;font-weight: bold;color:brown;background: #e3e3e3; "> Total </td>
                <td colspan="1" style="font-size: 0.8rem;text-align: right;border-bottom: 1px solid lightgray;font-weight: bold;font-weight: bold;color:brown;background: #e3e3e3;">{{ number_format($vodebit,0) }} </td>
                <td colspan="1" style="font-size: 0.8rem;text-align: right;border-bottom: 1px solid lightgray;font-weight: bold;font-weight: bold;color:brown;background: #e3e3e3;">{{ number_format($vocredit,0) }} </td>
                <td colspan="1" style="font-size: 0.8rem;text-align: right;border-bottom: 1px solid lightgray;font-weight: bold;font-weight: bold;color:brown;background: #e3e3e3;">{{ number_format($vadebit,0) }} </td>
                <td colspan="1" style="font-size: 0.8rem;text-align: right;border-bottom: 1px solid lightgray;font-weight: bold;font-weight: bold;color:brown;background: #e3e3e3;">{{ number_format($vacredit,0) }} </td>
                <td colspan="1" style="font-size: 0.8rem;text-align: right;border-bottom: 1px solid lightgray;font-weight: bold;font-weight: bold;color:brown;background: #e3e3e3;">{{ number_format($vcdebit,0) }} </td>
                <td colspan="1" style="font-size: 0.8rem;text-align: right;border-bottom: 1px solid lightgray;font-weight: bold;font-weight: bold;color:brown;background: #e3e3e3;">{{ number_format($vccredit,0) }} </td>
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
