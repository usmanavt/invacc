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
                <td style= "text-align:center; width:60%;">
                    <h1>{{ $hdng1 }} </h1>
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
                    {{-- <h3 style="font-size:0.8rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3> --}}
                    {{-- <h3 style="font-size:0.8rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3> --}}
                    {{-- <h3 style="font-size:0.8rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3> --}}
                    <h3> {{ $hdng2 }} </h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:1.5rem">SUPPLIER AGEING SUMMARY </span>
                </td>
            </tr>

        </tbody>
    </table>


    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Period
                </td>
                <td>
                    From {{ $fromdate }} to {{ $todate }}
                </td>
                {{-- <td>
                    Head Type
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
                <td colspan="1" width="5%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;">Srl</td>
                <td colspan="1" width="20%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;">Supplier</td>
                <td colspan="1" width="12%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Contract</td>
                <td colspan="6" width="63%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">D u r a t i o n ( D a y s )</td>
            </tr>


            <tr>
                <th class="column-headers" width="5%">No</th>
                <th class="column-headers" width="20%">Name</th>
                <th class="column-headers" width="12%">No</th>
                <th class="column-headers" width="9%">01-30</th>
                <th class="column-headers" width="9%">31-45</th>
                <th class="column-headers" width="9%">46-60</th>
                <th class="column-headers" width="9%">61-75</th>
                <th class="column-headers" width="9%">76-90</th>
                <th class="column-headers" width="9%">90-Over</th>
                <th class="column-headers" width="9%">Total</th>

            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>


           {{-- For Grand Total --}}
            {{ $vA = 0 }};{{ $vB = 0 }};{{ $vC = 0 }};{{ $vD = 0 }};{{ $vE = 0 }};{{ $vF = 0 }};{{ $vG = 0 }}

            {{-- For Sub Total --}}
            {{ $svA = 0 }};{{ $svB = 0 }};{{ $svC = 0 }};{{ $svD = 0 }};{{ $svE = 0 }};{{ $svF = 0 }};{{ $svG = 0 }}

            @for ($i = 0 ; $i < count($data) ; $i++)


            {{ $vA += $data[$i]->A }};{{ $vB += $data[$i]->B }};{{ $vC += $data[$i]->C }};{{ $vD += $data[$i]->D }}
            {{ $vE += $data[$i]->E }};{{ $vF += $data[$i]->F }};{{ $vG += $data[$i]->TOTAMOUNT }}






            @if( $i==0 )
            <tr>
                <td colspan="10"  style="text-align: left;border-bottom: 1px solid lightgray;font-weight: bold;font-size: 1.5rem;color:brown">{{ $data[$i]->rtitle }} </td>
            </tr>
            @else

            {{ $srno = $i - 1 }}

            {{ $svA += $data[$srno]->A }};{{ $svB += $data[$srno]->B }};{{ $svC += $data[$srno]->C }};{{ $svD += $data[$srno]->D }}
            {{ $svE += $data[$srno]->E }};{{ $svF += $data[$srno]->F }};{{ $svG += $data[$srno]->TOTAMOUNT }}

            @if ($data[$i]->srtid  <> $data[$srno]->srtid)

                <tr>
                    <td colspan="4" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($svA,0) }} </td>
                    <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($svB,0) }} </td>
                    <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($svC,0) }} </td>
                    <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($svD,0) }} </td>
                    <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($svE,0) }} </td>
                    <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($svF,0) }} </td>
                    <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($svG,0) }} </td>
                </tr>
                {{ $svA = 0 }};{{ $svB = 0 }};{{ $svC = 0 }};{{ $svD = 0 }};{{ $svE = 0 }};{{ $svF = 0 }};{{ $svG = 0 }}

                <tr>
                    <td colspan="10"  style="text-align: left;border-bottom: 1px solid lightgray;font-weight: bold;font-size: 1.5rem;color:brown">{{ $data[$i]->rtitle }} </td>
                </tr>
            @endif
            @endif

            <tr>

                <td style="text-align:center"; width="5%">{{ $i+1 }}</td>
                <td style="text-align: left"; width="20%">{{ $data[$i]->supname }} </td>
                <td style="text-align: center"; width="12%">{{ $data[$i]->phoneoff }} </td>
                <td style="text-align: right"; width="9%">{{ number_format($data[$i]->A,0) }} </td>
                <td style="text-align: right"; width="9%">{{ number_format($data[$i]->B,0) }} </td>
                <td style="text-align: right"; width="9%">{{ number_format($data[$i]->C,0) }} </td>
                <td style="text-align: right"; width="9%">{{ number_format($data[$i]->D,0) }} </td>
                <td style="text-align: right"; width="9%">{{ number_format($data[$i]->E,0) }} </td>
                <td style="text-align: right"; width="9%">{{ number_format($data[$i]->F,0) }} </td>
                <td style="text-align: right"; width="9%">{{ number_format($data[$i]->TOTAMOUNT,0) }} </td>

            </tr>
            @endfor

            <tr>
                {{-- <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold"> Total </td> --}}
                <td colspan="4" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($vA,0) }} </td>
                <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($vB,0) }} </td>
                <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($vC,0) }} </td>
                <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($vD,0) }} </td>
                <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($vE,0) }} </td>
                <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($vF,0) }} </td>
                <td colspan="1" style="text-align: right;border-bottom: 1px solid lightgray;font-weight: bold">{{ number_format($vG,0) }} </td>
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
    </div> --}}

    </body>
</html>
