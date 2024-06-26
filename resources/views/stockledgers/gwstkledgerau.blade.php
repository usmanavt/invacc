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
                    <h1>MUHAMMAD NAZIR & Co </h1>
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

                </td>

            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">Godown Wise Stock Movement Ledger Summary( For All Units )</span>
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
            {{-- <tr> <th class="column-headers" width="50%">OPENING BNALANCE</th></tr> --}}
            <tr>
                <td colspan="2" width="22%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> Material Description</td>
                <td colspan="3" width="12%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> Opening Balance</td>
                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> Purchase</td>
                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> Sale</td>
                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> Purchase Return</td>
                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> Sale Return</td>


                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> Godown-In</td>
                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> Godown-Out</td>



                <td colspan="3" width="12%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;"> Closing Balance</td> --}}
            </tr>

            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="column-headers" width="3%">S#</th>
                    <th class="column-headers" width="19%"></th>
                    {{-- <th class="column-headers" width="3%">Unit</th> --}}

                    <th class="column-headers" width="4%">Kg</th>
                    <th class="column-headers" width="4%">Pcs</th>
                    <th class="column-headers" width="4%">Feet</th>

                    <th class="column-headers" width="3%">Kg</th>
                    <th class="column-headers" width="3%">Pcs</th>
                    <th class="column-headers" width="3%">Feet</th>

                    <th class="column-headers" width="3%">Kg</th>
                    <th class="column-headers" width="3%">Pcs</th>
                    <th class="column-headers" width="3%">Feet</th>

                    <th class="column-headers" width="3%">Kg</th>
                    <th class="column-headers" width="3%">Pcs</th>
                    <th class="column-headers" width="3%">Feet</th>


                    <th class="column-headers" width="3%">Kg</th>
                    <th class="column-headers" width="3%">Pcs</th>
                    <th class="column-headers" width="3%">Feet</th>

                    <th class="column-headers" width="3%">Kg</th>
                    <th class="column-headers" width="3%">Pcs</th>
                    <th class="column-headers" width="3%">Feet</th>

                    <th class="column-headers" width="3%">Kg</th>
                    <th class="column-headers" width="3%">Pcs</th>
                    <th class="column-headers" width="3%">Feet</th>

                    <th class="column-headers" width="4%">Kg</th>
                    <th class="column-headers" width="4%">Pcs</th>
                    <th class="column-headers" width="4%">Feet</th>


            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>




            {{-- Category total --}}
            {{ $owtc = 0 }};{{ $opcsc = 0 }}; {{ $ofeetc = 0 }};{{ $pwtc = 0 }};{{ $ppcsc = 0 }}; {{ $pfeetc = 0 }};{{ $swtc = 0 }};{{ $spcsc = 0 }}; {{ $sfeetc = 0 }}
            {{ $cwtc = 0 }};{{ $cpcsc = 0 }}; {{ $cfeetc = 0 }};{{ $gwtc = 0 }};{{ $gpcsc = 0 }}; {{ $gfeetc = 0 }};{{ $giwtc = 0 }};{{ $gipcsc = 0 }}; {{ $gifeetc = 0 }}

            {{-- Source total --}}
            {{ $owtm= 0 }};{{ $opcsm = 0 }}; {{ $ofeetm = 0 }};{{ $pwtm = 0 }};{{ $ppcsm = 0 }}; {{ $pfeetm = 0 }};{{ $swtm = 0 }};{{ $spcsm = 0 }}; {{ $sfeetm = 0 }}
            {{ $cwtm = 0 }};{{ $cpcsm = 0 }}; {{ $cfeetm = 0 }};{{ $gwtm = 0 }};{{ $gpcsm = 0 }}; {{ $gfeetm = 0 }};{{ $giwtm = 0 }};{{ $gipcsm = 0 }}; {{ $gifeetm = 0 }}

            {{-- Grand total --}}
            {{ $owt = 0 }};{{ $opcs = 0 }}; {{ $ofeet = 0 }};{{ $pwt = 0 }};{{ $ppcs = 0 }}; {{ $pfeet = 0 }};{{ $swt = 0 }};{{ $spcs = 0 }}; {{ $sfeet = 0 }}
            {{ $cwt = 0 }};{{ $cpcs = 0 }}; {{ $cfeet = 0 }};{{ $gwt = 0 }};{{ $gpcs = 0 }}; {{ $gfeet = 0 }};{{ $giwt = 0 }};{{ $gipcs = 0 }}; {{ $gifeet = 0 }}


            @for ($i = 0 ; $i < count($data) ; $i++)

@if( $i==0 )
            <tr>
                <td colspan="26" width="100%" style="text-align: left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
            </tr>
@else
                {{ $srno = $i - 1 }}
                {{-- Category Total     --}}
                {{ $owtc += $data[$srno]->oqtykg }};{{ $opcsc += $data[$srno]->oqtypcs }};{{ $ofeetc += $data[$srno]->oqtyfeet }}
                {{ $pwtc += $data[$srno]->pqtykg }};{{ $ppcsc += $data[$srno]->pqtypcs }};{{ $pfeetc += $data[$srno]->pqtyfeet }}
                {{ $swtc += $data[$srno]->sqtykg }};{{ $spcsc += $data[$srno]->sqtypcs }};{{ $sfeetc += $data[$srno]->sqtyfeet }}
                {{ $cwtc += $data[$srno]->cbkg }};{{ $cpcsc += $data[$srno]->cbpcs }};{{ $cfeetc += $data[$srno]->cbfeet }}
                {{ $gwtc += $data[$srno]->gmqtykg }};{{ $gpcsc += $data[$srno]->gmqtypcs }};{{ $gfeetc += $data[$srno]->gmqtyfeet }}
                {{ $giwtc += $data[$srno]->gmiqtykg }};{{ $gipcsc += $data[$srno]->gmiqtypcs }};{{ $gifeetc += $data[$srno]->gmiqtyfeet }}


                {{-- Source Total     --}}
                {{ $owtm += $data[$srno]->oqtykg }};{{ $opcsm += $data[$srno]->oqtypcs }};{{ $ofeetm += $data[$srno]->oqtyfeet }}
                {{ $pwtm += $data[$srno]->pqtykg }};{{ $ppcsm += $data[$srno]->pqtypcs }};{{ $pfeetm += $data[$srno]->pqtyfeet }}
                {{ $swtm += $data[$srno]->sqtykg }};{{ $spcsm += $data[$srno]->sqtypcs }};{{ $sfeetm += $data[$srno]->sqtyfeet }}
                {{ $cwtm += $data[$srno]->cbkg }};{{ $cpcsm += $data[$srno]->cbpcs }};{{ $cfeetm += $data[$srno]->cbfeet }}
                {{ $gwtm += $data[$srno]->gmqtykg }};{{ $gpcsm += $data[$srno]->gmqtypcs }};{{ $gfeetm += $data[$srno]->gmqtyfeet }}
                {{ $giwtm += $data[$srno]->gmiqtykg }};{{ $gipcsm += $data[$srno]->gmiqtypcs }};{{ $gifeetm += $data[$srno]->gmiqtyfeet }}



        @if ($data[$i]->Itemgroupe  <> $data[$srno]->Itemgroupe)

        <tr>

            <td colspan="2"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">Total For {{ $data[$srno]->Itemgroupe }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($owtc,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($opcsc,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($ofeetc,0) }} </td>

            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($pwtc,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($ppcsc,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($pfeetc,0) }} </td>

            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($swtc,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($spcsc,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($sfeetc,0) }} </td>

            <td colspan="7"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($gwtc,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($gpcsc,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($gfeetc,0) }} </td>

            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($giwtc,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($gipcsc,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($gifeetc,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($cwtc,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($cpcsc,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($cfeetc,0) }} </td>

        </tr>

            {{-- Category total --}}
            {{ $owtc = 0 }};{{ $opcsc = 0 }}; {{ $ofeetc = 0 }};{{ $pwtc = 0 }};{{ $ppcsc = 0 }}; {{ $pfeetc = 0 }};{{ $swtc = 0 }};{{ $spcsc = 0 }}; {{ $sfeetc = 0 }}
            {{ $cwtc = 0 }};{{ $cpcsc = 0 }}; {{ $cfeetc = 0 }};{{ $gwtc = 0 }};{{ $gpcsc = 0 }}; {{ $gfeetc = 0 }};{{ $giwtc = 0 }};{{ $gipcsc = 0 }}; {{ $gifeetc = 0 }}
            @if ($data[$i]->matsource_id  == $data[$srno]->matsource_id)
                <tr>
                        <td colspan="26" width="100%" style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
                </tr>
            @endif
        @endif



        @if ($data[$i]->matsource_id  <> $data[$srno]->matsource_id)

        <tr>

            <td colspan="2"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">Total For {{ $data[$srno]->matsource }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($owtm,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($opcsm,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($ofeetm,0) }} </td>

            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($pwtm,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($ppcsm,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($pfeetm,0) }} </td>

            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($swtm,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($spcsm,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($sfeetm,0) }} </td>

            <td colspan="7"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($gwtm,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($gpcsm,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($gfeetm,0) }} </td>

            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($giwtm,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($gipcsm,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($gifeetm,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($cwtm,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($cpcsm,0) }} </td>
            <td colspan="1"  style="text-align: right;font-weight: bold;background: #e3e3e3;border-bottom: 1px solid lightgray;">{{ number_format($cfeetm,0) }} </td>

        </tr>

            {{-- Source total --}}
            {{ $owtm= 0 }};{{ $opcsm = 0 }}; {{ $ofeetm = 0 }};{{ $pwtm = 0 }};{{ $ppcsm = 0 }}; {{ $pfeetm = 0 }};{{ $swtm = 0 }};{{ $spcsm = 0 }}; {{ $sfeetm = 0 }}
            {{ $cwtm = 0 }};{{ $cpcsm = 0 }}; {{ $cfeetm = 0 }};{{ $gwtm = 0 }};{{ $gpcsm = 0 }}; {{ $gfeetm = 0 }};{{ $giwtm = 0 }};{{ $gipcsm = 0 }}; {{ $gifeetm = 0 }}

            <tr>
                    <td colspan="26" width="100%" style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
            </tr>
        @endif








@endif
            <tr>



                {{-- Grand Total     --}}
                {{ $owt += $data[$i]->oqtykg }};{{ $opcs += $data[$i]->oqtypcs }};{{ $ofeet += $data[$i]->oqtyfeet }}
                {{ $pwt += $data[$i]->pqtykg }};{{ $ppcs += $data[$i]->pqtypcs }};{{ $pfeet += $data[$i]->pqtyfeet }}
                {{ $swt += $data[$i]->sqtykg }};{{ $spcs += $data[$i]->sqtypcs }};{{ $sfeet += $data[$i]->sqtyfeet }}
                {{ $cwt += $data[$i]->cbkg }};{{ $cpcs += $data[$i]->cbpcs }};{{ $cfeet += $data[$i]->cbfeet }}
                {{ $gwt += $data[$i]->gmqtykg }};{{ $gpcs += $data[$i]->gmqtypcs }};{{ $gfeet += $data[$i]->gmqtyfeet }}
                {{ $giwt += $data[$i]->gmiqtykg }};{{ $gipcs += $data[$i]->gmiqtypcs }};{{ $gifeet += $data[$i]->gmiqtyfeet }}



                <td style="text-align:center" width="3%">{{ $i+1 }}</td>
                <td width="19%">{{ $data[$i]->matname}} </td>
                {{-- <td style="text-align:center" width="6%">{{ $data[$i]->unit }} </td> --}}

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->oqtykg,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->oqtypcs,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->oqtyfeet,0) }} </td>

                <td style="text-align:right" width="3%">{{ number_format($data[$i]->pqtykg,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->pqtypcs,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->pqtyfeet,0) }} </td>

                <td style="text-align:right" width="3%">{{ number_format($data[$i]->sqtykg,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->sqtypcs,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->sqtyfeet,0) }} </td>

                <td style="text-align:right" width="3%">{{ number_format($data[$i]->prqtykg,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->prqtypcs,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->prqtyfeet,0) }} </td>

                <td style="text-align:right" width="3%">{{ number_format($data[$i]->srqtykg,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->srqtypcs,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->srqtyfeet,0) }} </td>


                <td style="text-align:right" width="3%">{{ number_format($data[$i]->gmqtykg,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->gmqtypcs,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->gmqtyfeet,0) }} </td>

                <td style="text-align:right" width="3%">{{ number_format($data[$i]->gmiqtykg,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->gmiqtypcs,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->gmiqtyfeet,0) }} </td>




                <td style="text-align:right" width="4%">{{ number_format($data[$i]->cbkg,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->cbpcs,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->cbfeet,0) }} </td>


            </tr>
            @endfor
            <tr>
                <td colspan="3"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($owt,0) }} </td>
                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($opcs,0) }} </td>
                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($ofeet,0) }} </td>

                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($pwt,0) }} </td>
                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($ppcs,0) }} </td>
                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($pfeet,0) }} </td>

                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($swt,0) }} </td>
                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($spcs,0) }} </td>
                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($sfeet,0) }} </td>

                <td colspan="7"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($gwt,0) }} </td>
                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($gpcs,0) }} </td>
                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($gfeet,0) }} </td>

                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($giwt,0) }} </td>
                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($gipcs,0) }} </td>
                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($gifeet,0) }} </td>
                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($cwt,0) }} </td>
                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($cpcs,0) }} </td>
                <td colspan="1"  style="text-align: right;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($cfeet,0) }} </td>

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
