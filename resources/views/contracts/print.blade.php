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
    width:100%;.
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
                    <h3>Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                    <h3>PLOT NO. E-13, S.I.T.E AREA KARACHI MOBILE NO. 0333-3804744" </h3>
                    <h3>Phone : 021-32588781, 021-32574285 , Fax : 021-32588782 </h3>

                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">CONTRACTS </span>
                </td>
            </tr>

        {{-- <tr>

            <td  style="text-align: center;">
                <span style="font-size:1.5rem;font-weight: bold">{{ $ltype }}</span>
            </td>

        </tr> --}}


        </tbody>
    </table>

    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Supplier Name
                </td>
                <td>
                    {{ $data[0]->supname }}
                </td>

                <td>
                    Contract No
                </td>
                <td>
                    {{ $data[0]->invoiceno }}
                </td>
            </tr>
            <tr>
                <td>
                    Total Weight
                </td>
                <td style="font-weight: bold;color:brown" >   {{ $data[0]->totwt }}   </td>
                <td>
                    Contract Date
                </td>
                <td>
                    {{ $data[0]->invoice_date }}
                </td>

            </tr>
        </tbody>
    </table>
    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            {{-- <tr> <th class="column-headers" width="50%">OPENING BNALANCE</th></tr> --}}
            <tr>
                <td colspan="4" width="64%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> Material Description</td>
                {{-- <td colspan="2" width="14%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> Packing Lot</td> --}}
                <td colspan="2" width="16%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Quantity</td>

                <td colspan="2" width="20%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Supplier Value($)</td>
                {{-- <td colspan="2" width="14%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Invoice Value($)</td> --}}
                {{-- <td colspan="2" width="18%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Duty Value($)</td> --}}
            </tr>

            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="column-headers" width="3%">S#</th>
                    <th class="column-headers" width="40%">Material Name</th>
                    <th class="column-headers" width="16%">Size</th>
                    <th class="column-headers" width="5%">Unit</th>

                    {{-- <th class="column-headers" width="7%">Bundle1</th>
                    <th class="column-headers" width="7%">Bundle2</th> --}}

                    <th class="column-headers" width="8%">In Pcs</th>
                    <th class="column-headers" width="8%">In Kg</th>

                    <th class="column-headers" width="10%">Price</th>
                    <th class="column-headers" width="10%">Amount</th>

                    {{-- <th class="column-headers" width="7%">Price</th>
                    <th class="column-headers" width="7%">Amount</th> --}}

                    {{-- <th class="column-headers" width="9%">Price</th> --}}
                    {{-- <th class="column-headers" width="9%">Amount</th> --}}


            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>

            {{ $wt = 0 }};{{ $pcs = 0 }};{{ $supval = 0 }};{{ $invsval = 0 }};{{ $dutval = 0 }}

            @for ($i = 0 ; $i < count($data) ; $i++)
            {{-- @if( $i==0 )
            <tr>
                <td colspan="10" width="100%" style="text-align: left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
            </tr>
        @else

        {{ $srno = $i - 1 }}
        @if ($data[$i]->Itemgroupe  <> $data[$srno]->Itemgroupe)

.
              <tr>
                    <td colspan="10" width="100%" style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
             </tr>
        @endif

        @endif --}}


            <tr>

                {{ $wt += $data[$i]->wt }}.
                {{ $pcs += $data[$i]->totpcs }}
                {{ $supval += $data[$i]->vlues }}
                {{ $invsval += $data[$i]->invsvalue }}
                {{ $dutval += $data[$i]->dutval }}




                <td style="text-align:center" width="3%">{{ $i+1 }}</td>
                <td style="text-align:left" width="40%">{{ $data[$i]->material_title}} </td>
                <td style="text-align:center" width="16%">{{ $data[$i]->size}} </td>
                <td style="text-align:center" width="5%">{{ $data[$i]->unit}} </td>

                {{-- <td style="text-align:center" width="7%">{{ $data[$i]->bundle1 }} </td>
                <td style="text-align:center" width="7%">{{ $data[$i]->bundle2 }} </td> --}}

                <td style="text-align:right" width="8%">{{ number_format($data[$i]->totpcs,0) }} </td>
                <td style="text-align:right" width="8%">{{ number_format($data[$i]->wt,2) }} </td>

                <td style="text-align:right" width="10%">{{ number_format($data[$i]->price,3) }} </td>
                <td style="text-align:right" width="10%">{{ number_format($data[$i]->vlues,3) }} </td>

                {{-- <td style="text-align:right" width="7%">{{ number_format($data[$i]->invsrate,2) }} </td> --}}
                {{-- <td style="text-align:right" width="7%">{{ number_format($data[$i]->invsvalue,2) }} </td> --}}

                {{-- <td style="text-align:right" width="9%">{{ number_format($data[$i]->dtyrate,2) }} </td> --}}
                {{-- <td style="text-align:right" width="9%">{{ number_format($data[$i]->dutval,2) }} </td> --}}


            </tr>
            @endfor
            <tr>
                <td class="column-headers" colspan="3"  style="text-align: right;font-weight: bold; border-bottom: 1px solid lightgray;">Grand Total</td>
                <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($pcs,2) }} </td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($wt,2) }} </td>
                <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($supval,2) }} </td>
                {{-- <td colspan="4"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($dutval,2) }} </td> --}}

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
