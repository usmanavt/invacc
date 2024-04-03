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
.                    <th class="column-headers" width="9%">Closing<br>Balance</th>

            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>

            {{-- FOR SUBTOTAL --}}
            {{ $sob = 0 }};{{ $srcvd = 0 }};{{ $ssl = 0 }};{{ $scb = 0 }};{{ $spr = 0 }};{{ $ssr = 0 }}
            {{-- FOR GRANDTOTAL --}}
            {{ $vob = 0 }};{{ $vrcvd = 0 }};{{ $vsl = 0 }};{{ $vcb = 0 }};{{ $vpr = 0 }};{{ $vsr = 0 }}
            {{-- FOR LAST GROUP SUBTOTAL --}}
            {{-- {{ $sob1 = 0 }};{{ $srcvd1 = 0 }};{{ $ssl1 = 0 }};{{ $scb1 = 0 }};{{ $spr1 = 0 }};{{ $ssr1 = 0 }} --}}


            @for ($i = 0 ; $i < count($data) ; $i++)

            {{-- {{ $spr1 += $data[$i]->PURRET }};{{ $ssr1 += $data[$i]->SALRET }};{{ $scb1 += $data[$i]->CB }} --}}
            @if( $i==0 )
                <tr>
                    <td colspan="9" width="100%" style="text-align: left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
                </tr>
            @else

            {{ $srno = $i - 1 }}
            {{ $sob += $data[$srno]->OBALANCE }};{{ $srcvd += $data[$srno]->PURQTY }};{{ $ssl += $data[$srno]->SALQTY }};
            {{ $spr += $data[$srno]->PURRET }};{{ $ssr += $data[$srno]->SALRET }};{{ $scb += $data[$srno]->CB }}

                {{-- FOR LAST SUBTOTAL  --}}
            {{-- {{ $sob1 += $data[$i]->OBALANCE }};{{ $srcvd1 += $data[$i]->PURQTY }};{{ $ssl1 += $data[$i]->SALQTY }}; --}}





            @if ($data[$i]->Itemgroupe  <> $data[$srno]->Itemgroupe )

            <tr>
                <td colspan="2"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">Sub Total </td>
                <td colspan="2"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($sob,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($srcvd,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($ssl,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($spr,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($ssr,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($scb,0) }} </td>
            </tr>
           {{ $sob = 0 }};{{ $srcvd = 0 }};{{ $ssl = 0 }};{{ $scb = 0 }};{{ $spr = 0 }};{{ $ssr = 0 }}
           {{-- {{ $sob1 = 0 }};{{ $srcvd1 = 0 }};{{ $ssl1 = 0 }};{{ $scb1 = 0 }};{{ $spr1 = 0 }};{{ $ssr1 = 0 }} --}}

                 <tr>
                        <td colspan="9" width="100%" style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
                </tr>
            @endif
            @endif

            <tr>

                {{ $vob += $data[$i]->OBALANCE }};{{ $vrcvd += $data[$i]->PURQTY }};{{ $vsl += $data[$i]->SALQTY }}
                {{ $vpr += $data[$i]->PURRET }};{{ $vsr += $data[$i]->SALRET }};{{ $vcb += $data[$i]->CB }}




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

            {{-- <tr>
                <td colspan="2"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">Sub Total </td>
                <td colspan="2"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($sob1,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($srcvd1,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($ssl1,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($spr1,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($ssr1,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($scb1,0) }} </td>
            </tr> --}}


            <tr>

                <td colspan="2"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">Grand Total </td>
                <td colspan="2"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vob,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vrcvd,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vsl,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vpr,0) }} </td>
                <td colspan="1"  style= "font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vsr,0) }} </td>
                <td colspan="1"  style="font-weight: bold;background: #e3e3e3;text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vcb,0) }} </td>
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
