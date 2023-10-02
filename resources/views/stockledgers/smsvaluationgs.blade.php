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
                    <h3 style="font-size:0.7rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3>
                    <h3 style="font-size:0.7rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">Godown Wise Stock Movement Ledger "VALUATION"</span>
                </td>
            </tr>

        <tr>

            <td  style="text-align: center;">
                <span style="font-size:1.5rem;font-weight: bold">{{ $ltype }}</span>
            </td>

        </tr>

        <tr>

            <td  style="text-align: center;">
                <span style="font-size:1.5rem;font-weight: bold">{{ $data[0]->lidesc }}</span>
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

                    <th class="column-headers" width="4%">Qty</th>
                    <th class="column-headers" width="4%">Rate</th>
                    <th class="column-headers" width="4%">Value</th>

                    <th class="column-headers" width="4%">Qty</th>
                    <th class="column-headers" width="4%">Rate</th>
                    <th class="column-headers" width="4%">Value</th>

                    <th class="column-headers" width="4%">Qty</th>
                    <th class="column-headers" width="4%">Rate</th>
                    <th class="column-headers" width="4%">Value</th>

                    <th class="column-headers" width="4%">Qty</th>
                    <th class="column-headers" width="4%">Rate</th>
                    <th class="column-headers" width="4%">Value</th>


                    <th class="column-headers" width="4%">Qty</th>
                    <th class="column-headers" width="4%">Rate</th>
                    <th class="column-headers" width="4%">Value</th>

                    <th class="column-headers" width="4%">Qty</th>
                    <th class="column-headers" width="4%">Rate</th>
                    <th class="column-headers" width="4%">Value</th>


            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>

            {{ $oqty = 0 }};{{ $oval = 0 }}
            {{ $purqty = 0 }};{{ $pval = 0 }}
            {{ $salqty = 0 }};{{ $sval = 0 }}
            {{ $purret = 0 }};{{ $prval = 0 }}
            {{ $salret = 0 }};{{ $srval = 0 }}
            {{ $cb = 0 }};{{ $cb = 0 }}
            {{ $cbval = 0 }};{{ $cbval = 0 }}

            @for ($i = 0 ; $i < count($data) ; $i++)
            @if( $i==0 )
            <tr>
                <td colspan="20" width="100%" style="text-align: left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
            </tr>
        @else

        {{ $srno = $i - 1 }}
        @if ($data[$i]->Itemgroupe  <> $data[$srno]->Itemgroupe)
            <tr>
                    <td colspan="20" width="100%" style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
             </tr>
        @endif
        @endif


            <tr>

                {{ $oqty += $data[$i]->oqty }};{{ $oval += $data[$i]->oval }}
                {{ $purqty += $data[$i]->purqty }};{{ $pval += $data[$i]->pval }}
                {{ $salqty += $data[$i]->salqty }};{{ $sval += $data[$i]->sval }}
                {{ $purret += $data[$i]->purret }};{{ $prval += $data[$i]->prval }}
                {{ $salret += $data[$i]->salret }};{{ $srval += $data[$i]->srval }}
                {{ $cb += $data[$i]->cb }};{{ $cbval += $data[$i]->cbval }}




                <td style="text-align:center" width="3%">{{ $i+1 }}</td>
                <td width="25%">{{ $data[$i]->matname}} </td>
                {{-- <td style="text-align:center" width="6%">{{ $data[$i]->unit }} </td> --}}

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->oqty,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->orate,1) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->oval,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->purqty,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->prate,1) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->pval,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->salqty,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->srate,1) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->sval,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->purret,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->prrate,1) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->prval,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->salret,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->srrate,1) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->srval,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->cb,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->cbrate,1) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->cbval,0) }} </td>


            </tr>
            @endfor
            <tr>

                <td colspan="2" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">Total(s)</td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($oqty,0) }} </td>
                <td colspan="2" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($oval,0) }} </td>

                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($purqty,0) }} </td>
                <td colspan="2" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($pval,0) }} </td>

                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($salqty,0) }} </td>
                <td colspan="2" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($sval,0) }} </td>

                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($purret,0) }} </td>
                <td colspan="2" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($prval,0) }} </td>

                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($salret,0) }} </td>
                <td colspan="2" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($srval,0) }} </td>

                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($cb,0) }} </td>
                <td colspan="2" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($cbval,0) }} </td>

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
