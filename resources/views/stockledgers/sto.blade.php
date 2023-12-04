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
                    <h3 style="font-size:0.7rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3>
                    <h3 style="font-size:0.7rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">Stock Transfer Order</span>
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

            {{-- <tr>
                <td style="text-align: center">
                    From {{ $fromdate }} to {{ $todate }}
                </td>

            </tr> --}}
            <tr>
                <td style="text-align: center">
                    From : <span style="font-size:1rem;font-weight: bold;color:brown">{{ $data[0]->fromloc }}</span>     To:
                    <span style="font-size:1rem;font-weight: bold;color:brown">{{ $data[0]->toloc }}</span>
                </td>
                <td style="text-align: center">
                    STO Date: <span style="font-size:1rem;font-weight: bold;color:brown">{{ $data[0]->stodate }}</span>
                </td>
                <td style="text-align: center">
                    STO No:<span style="font-size:1rem;font-weight: bold;color:brown">{{ $data[0]->stono }}</span>
                </td>

            </tr>

            <tr>
                <td style="text-align: center">
                    GatePass Status : <span style="font-size:1rem;font-weight: bold;color:brown">{{ $data[0]->compstatus }}</span>

                </td>
                <td style="text-align: center">
                    Movement Date: <span style="font-size:1rem;font-weight: bold;color:brown">{{ $data[0]->clrddate }}</span>
                </td>
                <td style="text-align: center">
                    Movement No:<span style="font-size:1rem;font-weight: bold;color:brown">{{ $data[0]->clrdid }}</span>
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
                    <th class="column-headers" width="25%">Material Name</th>
                    <th class="column-headers" width="15%">Size</th>
                    <th class="column-headers" width="6%">Unit</th>
                    <th class="column-headers" width="9%">Qty in <br> Kg</th>
                    <th class="column-headers" width="9%">Qty in <br> pcs</th>
                    <th class="column-headers" width="9%">Qty in <br> Feet</th>
                    <th class="column-headers" width="10%">Item <br> Cost</th>
                    <th class="column-headers" width="12%">Item <br> Value</th>
                    {{-- <th class="column-headers" width="9%">Closing<br>Balance</th> --}}

            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{ $vob = 0 }}
            {{ $vrcvd = 0 }}
            {{ $vsl = 0 }}
            {{ $vcb = 0 }}

            @for ($i = 0 ; $i < count($data) ; $i++)

            {{-- @if( $i==0 )
                <tr>
                    <td colspan="9" width="100%" style="text-align: left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
                </tr>
            @else

            {{ $srno = $i - 1 }}
            @if ($data[$i]->Itemgroupe  <> $data[$srno]->Itemgroupe )
                <tr>
                        <td colspan="9" width="100%" style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
                </tr>
            @endif
            @endif --}}

            <tr>

                {{ $vob += $data[$i]->qtykg }}
                {{ $vrcvd += $data[$i]->qtypcs }}
                {{ $vsl += $data[$i]->qtyfeet }}
                {{ $vcb += $data[$i]->saleamnt }}



                <td style="text-align:center" width="5%">{{ $i+1 }}</td>
                <td width="25%">{{ $data[$i]->material_title}} </td>
                <td style="text-align:center" width="15%">{{ $data[$i]->dimension }} </td>
                <td style="text-align:center" width="6%">{{ $data[$i]->sku }} </td>
                <td style="text-align:right" width="9%">{{ number_format($data[$i]->qtykg,2) }} </td>
                <td style="text-align:right" width="9%">{{ number_format($data[$i]->qtypcs,2) }} </td>
                <td style="text-align:right" width="9%">{{ number_format($data[$i]->qtyfeet,2) }} </td>
                <td style="text-align:right" width="10%">{{ number_format($data[$i]->price,2) }} </td>
                <td style="text-align:right" width="12%">{{ number_format($data[$i]->saleamnt,0) }} </td>
                {{-- <td style="text-align:right" width="9%">{{ number_format($data[$i]->CB,0) }} </td> --}}
            </tr>
            @endfor
            <tr>
                {{-- <td colspan="9" width="100%" style="text-align: right;border-bottom: 1px solid lightgray;"></td> --}}

                <td colspan="5"  style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vob,0) }} </td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vrcvd,0) }} </td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vsl,0) }} </td>
                <td colspan="2"  style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vcb,0) }} </td>
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
