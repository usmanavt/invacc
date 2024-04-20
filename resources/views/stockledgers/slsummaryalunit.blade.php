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
    font-size: 0.9rem;
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
                    <h1>MUHAMMAD NAZIR & Co</h1>
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
                    <h3 style="font-size:0.7rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                    <h3 style="font-size:0.7rem">PLOT NO. E-13, S.I.T.E AREA KARACHI MOBILE NO. 0333-3804744</h3>
                    <h3 style="font-size:0.7rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3>

                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">Stock Movement Ledger Summary</span>
                </td>
            </tr>

        <tr>

            <td  style="text-align: center;">
                <span style="font-size:1.5rem;font-weight: bold">{{ $ltype }}</span>
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
            {{-- <tr> <th class="column-headers" width="50%">OPENING BNALANCE</th></tr> --}}
            <tr>
                <td colspan="2" width="28%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> Material Description</td>
                <td colspan="3" width="12%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> Opening Balance</td>
                <td colspan="3" width="12%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> Purchase</td>
                <td colspan="3" width="12%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> Sale</td>
                <td colspan="3" width="12%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> Purchase Return</td>
                <td colspan="3" width="12%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> Sale Return</td>
                <td colspan="3" width="12%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> Closing Balance</td> --}}
            </tr>

            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="column-headers" width="3%">S#</th>
                    <th class="column-headers" width="25%"></th>
                    {{-- <th class="column-headers" width="3%">Unit</th> --}}

                    <th class="column-headers" width="4%">Kg</th>
                    <th class="column-headers" width="4%">Pcs</th>
                    <th class="column-headers" width="4%">Feet</th>

                    <th class="column-headers" width="4%">Kg</th>
                    <th class="column-headers" width="4%">Pcs</th>
                    <th class="column-headers" width="4%">Feet</th>

                    <th class="column-headers" width="4%">Kg</th>
                    <th class="column-headers" width="4%">Pcs</th>
                    <th class="column-headers" width="4%">Feet</th>

                    <th class="column-headers" width="4%">Kg</th>
                    <th class="column-headers" width="4%">Pcs</th>
                    <th class="column-headers" width="4%">Feet</th>


                    <th class="column-headers" width="4%">Kg</th>
                    <th class="column-headers" width="4%">Pcs</th>
                    <th class="column-headers" width="4%">Feet</th>

                    <th class="column-headers" width="4%">Kg</th>
                    <th class="column-headers" width="4%">Pcs</th>
                    <th class="column-headers" width="4%">Feet</th>


            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>


            {{-- for grand total --}}
            {{ $owt = 0 }};{{ $opcs = 0 }}; {{ $ofeet = 0 }}; {{ $pwt = 0 }};{{ $ppcs = 0 }}; {{ $pfeet = 0 }};
            {{ $swt = 0 }};{{ $spcs = 0 }}; {{ $sfeet = 0 }}; {{ $cwt = 0 }};{{ $cpcs = 0 }}; {{ $cfeet = 0 }};

            {{-- for Sub total --}}
            {{ $owts = 0 }};{{ $opcss = 0 }}; {{ $ofeets = 0 }}; {{ $pwts = 0 }};{{ $ppcss = 0 }}; {{ $pfeets = 0 }};
            {{ $swts = 0 }};{{ $spcss = 0 }}; {{ $sfeets = 0 }}; {{ $cwts = 0 }};{{ $cpcss = 0 }}; {{ $cfeets = 0 }};

            {{-- for source Sub total --}}
            {{ $owtm = 0 }};{{ $opcsm = 0 }}; {{ $ofeetm = 0 }}; {{ $pwtm = 0 }};{{ $ppcsm = 0 }}; {{ $pfeetm = 0 }};
            {{ $swtm = 0 }};{{ $spcsm = 0 }}; {{ $sfeetm = 0 }}; {{ $cwtm = 0 }};{{ $cpcsm = 0 }}; {{ $cfeetm = 0 }};






            @for ($i = 0 ; $i < count($data) ; $i++)
 @if( $i==0 )
            <tr>
                <td colspan="20" width="100%" style="text-align: left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
            </tr>
        @else

        {{ $srno = $i - 1 }}

            {{-- fro sub total Group --}}
            {{ $owts += $data[$srno]->oqtykg }};{{ $opcss += $data[$srno]->oqtypcs }};{{ $ofeets += $data[$srno]->oqtyfeet }}
            {{ $pwts += $data[$srno]->pqtykg }};{{ $ppcss += $data[$srno]->pqtypcs }};{{ $pfeets += $data[$srno]->pqtyfeet }}
            {{ $swts += $data[$srno]->sqtykg }};{{ $spcss += $data[$srno]->sqtypcs }};{{ $sfeets += $data[$srno]->sqtyfeet }}
            {{ $cwts += $data[$srno]->cbkg }};{{ $cpcss += $data[$srno]->cbpcs }};{{ $cfeets += $data[$srno]->cbfeet }}

            {{-- fro sub total Source --}}
            {{ $owtm += $data[$srno]->oqtykg }};{{ $opcsm += $data[$srno]->oqtypcs }};{{ $ofeetm += $data[$srno]->oqtyfeet }}
            {{ $pwtm += $data[$srno]->pqtykg }};{{ $ppcsm += $data[$srno]->pqtypcs }};{{ $pfeetm += $data[$srno]->pqtyfeet }}
            {{ $swtm += $data[$srno]->sqtykg }};{{ $spcsm += $data[$srno]->sqtypcs }};{{ $sfeetm += $data[$srno]->sqtyfeet }}
            {{ $cwtm += $data[$srno]->cbkg }};{{ $cpcsm += $data[$srno]->cbpcs }};{{ $cfeetm += $data[$srno]->cbfeet }}


        @if ($data[$i]->Itemgroupe  <> $data[$srno]->Itemgroupe)

                {{-- for subtotal --}}
                <tr>
                    <td colspan="2" style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;"> Total For {{ $data[$srno]->Itemgroupe }}</td>
                    <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($owts) }} </td>
                    <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($opcss,0) }} </td>
                    <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($ofeets,0) }} </td>

                    <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($pwts,0) }} </td>
                    <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($ppcss,0) }} </td>
                    <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($pfeets,0) }} </td>

                    <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($swts,0) }} </td>
                    <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($spcss,0) }} </td>
                    <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($sfeets,0) }} </td>

                    <td colspan="7"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($cwts,0) }} </td>
                    <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($cpcss,0) }} </td>
                    <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($cfeets,0) }} </td>

                </tr>
                    @if ($data[$i]->matsource_id  == $data[$srno]->matsource_id )
                        <tr>
                                <td colspan="20" width="100%" style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
                        </tr>
                    @endif

                {{-- for Sub total --}}
                {{ $owts = 0 }};{{ $opcss = 0 }}; {{ $ofeets = 0 }}; {{ $pwts = 0 }};{{ $ppcss = 0 }}; {{ $pfeets = 0 }};
                {{ $swts = 0 }};{{ $spcss = 0 }}; {{ $sfeets = 0 }}; {{ $cwts = 0 }};{{ $cpcss = 0 }}; {{ $cfeets = 0 }};
        @endif

        @if ($data[$i]->matsource_id  <> $data[$srno]->matsource_id)

                {{-- for subtotal Source --}}
                <tr>
                    <td colspan="2" style="background:gray;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;"> Total For {{$data[$srno]->matsource}}</td>
                    <td colspan="1"  style="background: gray;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($owtm) }} </td>
                    <td colspan="1"  style="background: gray;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($opcsm,0) }} </td>
                    <td colspan="1"  style="background: gray;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($ofeetm,0) }} </td>

                    <td colspan="1"  style="background: gray;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($pwtm,0) }} </td>
                    <td colspan="1"  style="background: gray;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($ppcsm,0) }} </td>
                    <td colspan="1"  style="background: gray;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($pfeetm,0) }} </td>

                    <td colspan="1"  style="background: gray;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($swtm,0) }} </td>
                    <td colspan="1"  style="background: gray;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($spcsm,0) }} </td>
                    <td colspan="1"  style="background: gray;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($sfeetm,0) }} </td>

                    <td colspan="7"  style="background: gray;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($cwtm,0) }} </td>
                    <td colspan="1"  style="background: gray;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($cpcsm,0) }} </td>
                    <td colspan="1"  style="background: gray;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($cfeetm,0) }} </td>

                </tr>

                    <tr>
                            <td colspan="20" width="100%" style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
                    </tr>

                {{-- for Sub total --}}
                {{ $owtm = 0 }};{{ $opcsm = 0 }}; {{ $ofeetm = 0 }}; {{ $pwtm = 0 }};{{ $ppcsm = 0 }}; {{ $pfeetm = 0 }};
                {{ $swtm = 0 }};{{ $spcsm = 0 }}; {{ $sfeetm = 0 }}; {{ $cwtm = 0 }};{{ $cpcsm = 0 }}; {{ $cfeetm = 0 }};
        @endif




@endif


            <tr>

                {{ $owt += $data[$i]->oqtykg }};{{ $opcs += $data[$i]->oqtypcs }};{{ $ofeet += $data[$i]->oqtyfeet }}
                {{ $pwt += $data[$i]->pqtykg }};{{ $ppcs += $data[$i]->pqtypcs }};{{ $pfeet += $data[$i]->pqtyfeet }}
                {{ $swt += $data[$i]->sqtykg }};{{ $spcs += $data[$i]->sqtypcs }};{{ $sfeet += $data[$i]->sqtyfeet }}
                {{ $cwt += $data[$i]->cbkg }};{{ $cpcs += $data[$i]->cbpcs }};{{ $cfeet += $data[$i]->cbfeet }}

                <td style="text-align:center" width="3%">{{ $i+1 }}</td>
                <td width="25%">{{ $data[$i]->matname}} </td>
                {{-- <td style="text-align:center" width="6%">{{ $data[$i]->unit }} </td> --}}

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->oqtykg,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->oqtypcs,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->oqtyfeet,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->pqtykg,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->pqtypcs,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->pqtyfeet,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->sqtykg,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->sqtypcs,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->sqtyfeet,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->prqtykg,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->prqtypcs,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->prqtyfeet,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->srqtykg,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->srqtypcs,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->srqtyfeet,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->cbkg,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->cbpcs,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->cbfeet,0) }} </td>


            </tr>
            @endfor
            <tr>
                <td colspan="2"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;"> Grand Total</td>
                <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($owt,0) }} </td>
                <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($opcs,0) }} </td>
                <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($ofeet,0) }} </td>

                <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($pwt,0) }} </td>
                <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($ppcs,0) }} </td>
                <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($pfeet,0) }} </td>

                <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($swt,0) }} </td>
                <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($spcs,0) }} </td>
                <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($sfeet,0) }} </td>

                <td colspan="7"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($cwt,0) }} </td>
                <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($cpcs,0) }} </td>
                <td colspan="1"  style="background: #e3e3e3;font-weight: bold;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($cfeet,0) }} </td>

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
