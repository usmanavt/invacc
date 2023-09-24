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
    /* border-bottom: 2px double gray; */
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
    border-right: 1px solid lightgray;
    border-top: 1px solid lightgray;
    text-align: left;
    font-size: 1rem;
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
                    <span style="font-size:1.5rem">Godown Wise Stock Movement Ledger Summary( For Master Unit )</span>
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
                <td style="text-align: center">
                    From {{ $fromdate }} to {{ $todate }}
                </td>

            </tr>
        </tbody>
    </table>
    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="column-headers" width="5%">S#</th>
                    <th class="column-headers" width="35%">Material Name</th>
                    <th class="column-headers" width="6%">Unit</th>
                    <th class="column-headers" width="9%">Opening<br>Balance</th>
                    <th class="column-headers" width="9%">Purchasing</th>
                    <th class="column-headers" width="9%">Sale</th>
                    <th class="column-headers" width="9%">Purchase<br>Return</th>
                    <th class="column-headers" width="9%">Sale<br>Return</th>
                    <th class="column-headers" width="9%">Closing<br>Balance</th>

            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{-- {{ $vtotpcs = 0 }}
            {{ $vwt = 0 }}
            {{ $vvlues = 0 }} --}}
            {{-- {{ $pcspbundle2 = 0 }} --}}

            @for ($i = 0 ; $i < count($data) ; $i++)

            @if( $i==0 )
                <tr>
                    <td colspan="9" width="100%" style="text-align: left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
                </tr>
            @else

            {{ $srno = $i - 1 }}
            @if ($data[$i]->Itemgroupe  <> $data[$srno]->Itemgroupe)
                <tr>
                        <td colspan="9" width="100%" style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
                </tr>
            @endif
            @endif

            {{-- {{ $vmatsrc = $data[$i]->matsource }}   --}}



            <tr>

                {{-- {{ $vtotpcs += $data[$i]->totpcs }} --}}
                {{-- {{ $vwt += $data[$i]->wt }} --}}
                {{-- {{ $vvlues += $data[$i]->vlues }} --}}


                <td style="text-align:center" width="5%">{{ $i+1 }}</td>
                <td width="35%">{{ $data[$i]->matname}} </td>
                <td style="text-align:center" width="6%">{{ $data[$i]->unit }} </td>
                <td style="text-align:right" width="9%">{{ number_format($data[$i]->OBALANCE,0) }} </td>
                <td style="text-align:right" width="9%">{{ number_format($data[$i]->PURQTY,0) }} </td>
                <td style="text-align:right" width="9%">{{ number_format($data[$i]->SALQTY,0) }} </td>
                <td style="text-align:right" width="9%">{{ number_format($data[$i]->PURRET,0) }} </td>
                <td style="text-align:right" width="9%">{{ number_format($data[$i]->SALRET,0) }} </td>
                <td style="text-align:right" width="9%">{{ number_format($data[$i]->CB,0) }} </td>
            </tr>
            @endfor
            <tr>
                <td colspan="9" width="100%" style="text-align: right;border-bottom: 1px solid lightgray;"></td>
                {{-- <td colspan="4" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vtotpcs,0) }} </td>
                <td class="1" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vwt,0) }} </td>
                <td class="2" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vvlues,0) }} </td> --}}
           </tr>






        </tbody>
    </table>

    {{-- Footer  --}}
    <div style="margin-top:64px;">
        <table >

            {{-- <tr style="margin-top:16px;margin-bottom:16px;">
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
            </tr> --}}






        </table>






    </div>



    </body>

</html>
