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
                </td>
            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">Stock Movement Ledger "VALUATION" </span>
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
                <td colspan="3" width="28%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> Material Description</td>
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
                    <th class="column-headers" width="20%"></th>
                    <th class="column-headers" width="5%">Unit</th>

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


            {{-- FOR GRAND TOTAL --}}
            {{ $oqty = 0 }};{{ $oval = 0 }};{{ $purqty = 0 }};{{ $pval = 0 }};{{ $salqty = 0 }};{{ $sval = 0 }};{{ $purret = 0 }};
            {{ $prval = 0 }};{{ $salret = 0 }};{{ $srval = 0 }};{{ $cb = 0 }};{{ $cb = 0 }};{{ $cbval = 0 }};{{ $cbval = 0 }};

            {{-- FOR SUB TOTAL --}}
            {{ $oqtys = 0 }};{{ $ovals = 0 }};{{ $purqtys = 0 }};{{ $pvals = 0 }};{{ $salqtys = 0 }};{{ $svals = 0 }};{{ $purrets = 0 }};
            {{ $prvals = 0 }};{{ $salrets = 0 }};{{ $srvals = 0 }};{{ $cbs = 0 }};{{ $cbs = 0 }};{{ $cbvals = 0 }};{{ $cbvals = 0 }};


            @for ($i = 0 ; $i < count($data) ; $i++)
            @if( $i==0 )

            <tr>
                <td colspan="21" width="100%" style="text-align: left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
            </tr>
        @else

                {{ $srno = $i - 1 }}

                {{-- FOR GRAND TOTAL  --}}
                {{ $oqtys += $data[$srno]->oqty }};{{ $ovals += $data[$srno]->oval }};{{ $purqtys += $data[$srno]->purqty }};{{ $pvals += $data[$srno]->pval }};
                {{ $salqtys += $data[$srno]->salqty }};{{ $svals += $data[$srno]->sval }};{{ $purrets += $data[$srno]->purret }};{{ $prvals += $data[$srno]->prval }};
                {{ $salrets += $data[$srno]->salret }};{{ $srvals += $data[$srno]->srval }};{{ $cbs += $data[$i]->cb }};{{ $cbvals += $data[$srno]->cbval }};



        @if ($data[$i]->Itemgroupe  <> $data[$srno]->Itemgroupe)

        <tr>

            <td colspan="3"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">Total(s)</td>
            <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($oqtys,0) }} </td>
            <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($ovals,0) }} </td>

            <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($purqtys,0) }} </td>
            <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($pvals,0) }} </td>

            <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($salqtys,0) }} </td>
            <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($svals,0) }} </td>

            <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($purrets,0) }} </td>
            <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($prvals,0) }} </td>

            <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($salrets,0) }} </td>
            <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($srvals,0) }} </td>

            <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($cbs,0) }} </td>
            <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($cbvals,0) }} </td>

        </tr>

             <tr>
                    <td colspan="21" width="100%" style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
             </tr>
            {{-- FOR SUB TOTAL --}}
            {{ $oqtys = 0 }};{{ $ovals = 0 }};{{ $purqtys = 0 }};{{ $pvals = 0 }};{{ $salqtys = 0 }};{{ $svals = 0 }};{{ $purrets = 0 }};
            {{ $prvals = 0 }};{{ $salrets = 0 }};{{ $srvals = 0 }};{{ $cbs = 0 }};{{ $cbs = 0 }};{{ $cbvals = 0 }};{{ $cbvals = 0 }};





        @endif
        @endif


            <tr>

                {{-- FOR GRAND TOTAL  --}}
                {{ $oqty += $data[$i]->oqty }};{{ $oval += $data[$i]->oval }};{{ $purqty += $data[$i]->purqty }};{{ $pval += $data[$i]->pval }};
                {{ $salqty += $data[$i]->salqty }};{{ $sval += $data[$i]->sval }};{{ $purret += $data[$i]->purret }};{{ $prval += $data[$i]->prval }};
                {{ $salret += $data[$i]->salret }};{{ $srval += $data[$i]->srval }};{{ $cb += $data[$i]->cb }};{{ $cbval += $data[$i]->cbval }};




                <td style="text-align:center" width="3%">{{ $i+1 }}</td>
                <td width="20%">{{ $data[$i]->matname}} </td>
                <td style="text-align:center" width="5%">{{ $data[$i]->unit }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->oqty,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->orate,2) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->oval,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->purqty,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->prate,2) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->pval,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->salqty,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->srate,2) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->sval,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->purret,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->prrate,2) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->prval,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->salret,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->srrate,2) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->srval,0) }} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->cb,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->cbrate,2) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->cbval,0) }} </td>


            </tr>
            @endfor
            <tr>

                <td colspan="3"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">Total(s)</td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($oqty,0) }} </td>
                <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($oval,0) }} </td>

                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($purqty,0) }} </td>
                <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($pval,0) }} </td>

                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($salqty,0) }} </td>
                <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($sval,0) }} </td>

                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($purret,0) }} </td>
                <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($prval,0) }} </td>

                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($salret,0) }} </td>
                <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($srval,0) }} </td>

                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($cb,0) }} </td>
                <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($cbval,0) }} </td>

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
