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
                    <h1>{{ $hdng1 }} </h1>
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
                    {{-- <h3 style="font-size:0.7rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                    <h3 style="font-size:0.7rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3>
                    <h3 style="font-size:0.7rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3> --}}
                    <h3> {{ $hdng2 }}  </h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">DUTY CLEARANCE STATUS </span>
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
                {{-- <td>
                    Supplier Name
                </td>
                <td>
                    {{ $data[0]->supname }}
                </td> --}}

                {{-- <td>
                    Invoice No
                </td>
                <td>
                    {{ $data[0]->purinvsno }}
                </td> --}}

                {{-- <td>
                    Contract Id
                </td>
                <td>
                    {{ $data[0]->contract_id }}
                </td> --}}

            </tr>
            <tr>
                <td>
                    Period
                </td>
                <td>
                    From {{ $fromdate }} to {{ $todate }}
                </td>
                {{-- <td>
                    Invoice Date
                </td>
                <td>
                    {{ $data[0]->invoice_date }}
                </td>

                <td>
                    Contract Date
                </td>
                <td>
                    {{ $data[0]->contract_date }}
                </td>
 --}}

            </tr>
        </tbody>
    </table>
    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            {{-- <tr> <th class="column-headers" width="50%">OPENING BNALANCE</th></tr> --}}
            <tr>
                <td colspan="2" width="8%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;">GD Descr.</td>
                <td colspan="2" width="16%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;">Invoice</td>
                <td colspan="2" width="16%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">GD</td>
                <td colspan="2" width="12%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Conversion</td>
                <td colspan="3" width="18%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Data For Clearance</td>
                <td colspan="2" width="12%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Data Cleared</td>
                {{-- <td colspan="7" width="29%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Duty Cleared</td> --}}
                <td colspan="3" width="18%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Clearance Pending</td>


                {{-- <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Allah Malik Shop</td>
                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">E - 24</td>
                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Bolton Shop</td>
                <td colspan="3" width="12%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Total Receiving</td>
                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Pending</td> --}}

            </tr>

            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="column-headers" width="2%">S#</th>
                    {{-- <th class="column-headers" width="2%">srtid</th> --}}
                    <th class="column-headers" width="6%">Description</th>
                    <th class="column-headers" width="8%">Date</th>
                    <th class="column-headers" width="8%">No</th>
                    <th class="column-headers" width="8%">Date</th>
                    <th class="column-headers" width="8%">No</th>
                    <th class="column-headers" width="6%">Rate</th>
                    <th class="column-headers" width="6%">Insur.</th>
                    <th class="column-headers" width="6%">Bundle</th>
                    <th class="column-headers" width="6%">Weight</th>
                    <th class="column-headers" width="6%">Duty</th>
                    <th class="column-headers" width="6%">Bundle</th>
                    <th class="column-headers" width="6%">Weight</th>
                    {{-- <th class="column-headers" width="4%">CD</th>
                    <th class="column-headers" width="4%">ST</th>
                    <th class="column-headers" width="4%">RD</th>
                    <th class="column-headers" width="4%">ACD</th>
                    <th class="column-headers" width="4%">AST</th>
                    <th class="column-headers" width="4%">IT</th>
                    <th class="column-headers" width="5%">Total</th> --}}
                    <th class="column-headers" width="6%">Bundle</th>
                    <th class="column-headers" width="6%">Weight</th>
                    <th class="column-headers" width="6%">Duty</th>

            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>

           {{ $vbund = 0 }};{{ $vwt = 0 }};{{ $vcd = 0 }};{{ $vst = 0 }};{{ $vrd = 0 }};{{ $vacd = 0 }};{{ $vast = 0 }}
            {{ $vit = 0 }};{{ $vtotal = 0 }};{{ $vpbund = 0 }};{{ $vpwt = 0 }};{{ $vpduty = 0 }}

            @for ($i = 0 ; $i < count($data) ; $i++)
            {{-- @if( $i==0 )
            <tr>
                <td colspan="20" width="100%" style="text-align: left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
            </tr>
        @else

        {{ $srno = $i - 1 }}
        @if ($data[$i]->Itemgroupe  <> $data[$srno]->Itemgroupe)


              <tr>
                    <td colspan="20" width="100%" style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
             </tr>
        @endif --}}

        {{-- @endif --}}
        {{-- {{ $vinur = 0 }};{{ $vbund = 0 }};{{ $vwt = 0 }};{{ $vcd = 0 }};{{ $vst = 0 }};{{ $vrd = 0 }};{{ $vacd = 0 }};{{ $vast = 0 }} --}}
        {{-- {{ $vit = 0 }};{{ $vtotal = 0 }};{{ $vpbund = 0 }};{{ $vpwt = 0 }};{{ $vpduty = 0 }} --}}


            <tr>

                {{ $vbund += $data[$i]->dpackingwt }}
                {{ $vwt += $data[$i]->dtwt }}
                {{ $vcd += $data[$i]->cda }}
                {{ $vst += $data[$i]->sta }}
                {{ $vrd += $data[$i]->rda }}
                {{ $vacd += $data[$i]->acda }}
                {{ $vast += $data[$i]->asta }}
                {{ $vit += $data[$i]->ita }}
                {{ $vtotal += $data[$i]->dtduty }}



                {{-- <td  width="30%"> <span style="font-size:0.8rem;font-weight: bold;color:brown">{{ $data[$i]->SupName }}</span> --}}

        @if(  $data[$i]->srtid == 1 )
                <td style="text-align:center" width="2%">{{ $i+1 }}</td>
                {{-- <td style="text-align:left" width="2%">{{ $data[$i]->srtid}} </td> --}}
                <td style="text-align:left ;font-weight: bold;color:brown" width="6%">{{ $data[$i]->descr}} </td>
                <td style="text-align:center;font-weight: bold;color:brown" width="8%">{{ $data[$i]->invoice_date}} </td>
                <td style="text-align:center;font-weight: bold;color:brown" width="8%">{{ $data[$i]->invoiceno}} </td>
                <td style="text-align:center;font-weight: bold;color:brown" width="8%">{{ $data[$i]->machine_date}} </td>
                <td style="text-align:center;font-weight: bold;color:brown" width="8%">{{ $data[$i]->machineno}} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="6%">{{ number_format($data[$i]->conversionrate,2) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="6%">{{ number_format($data[$i]->insurance,0) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="6%">{{ number_format($data[$i]->packingwt,0) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="6%">{{ number_format($data[$i]->twt,0) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="6%">{{ number_format($data[$i]->tduty,0) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="6%">{{ number_format($data[$i]->dpackingwt,0) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="6%">{{ number_format($data[$i]->dtwt,0) }} </td>
                {{-- <td style="text-align:right;font-weight: bold;color:brown" width="4%">{{ number_format($data[$i]->cda,0) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="4%">{{ number_format($data[$i]->sta,0) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="4%">{{ number_format($data[$i]->rda,0) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="4%">{{ number_format($data[$i]->acda,0) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="4%">{{ number_format($data[$i]->asta,0) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="4%">{{ number_format($data[$i]->ita,0) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="5%">{{ number_format($data[$i]->dtduty,0) }} </td> --}}
                <td style="text-align:right;font-weight: bold;color:brown" width="6%">{{ number_format($data[$i]->pndpkgs,0) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="6%">{{ number_format($data[$i]->pndwt,0) }} </td>
                <td style="text-align:right;font-weight: bold;color:brown" width="6%">{{ number_format($data[$i]->pndval,0) }} </td>
    @else


                <td style="text-align:center" width="2%">{{ $i+1 }}</td>
                {{-- <td style="text-align:left" width="2%">{{ $data[$i]->srtid}} </td> --}}
                <td style="text-align:left" width="6%">{{ $data[$i]->descr}} </td>
                <td style="text-align:center" width="8%">{{ $data[$i]->invoice_date}} </td>
                <td style="text-align:center" width="8%">{{ $data[$i]->invoiceno}} </td>
                <td style="text-align:center" width="8%">{{ $data[$i]->machine_date}} </td>
                <td style="text-align:center" width="8%">{{ $data[$i]->machineno}} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->conversionrate,2) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->insurance,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->packingwt,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->twt,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->tduty,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->dpackingwt,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->dtwt,0) }} </td>
                {{-- <td style="text-align:right" width="4%">{{ number_format($data[$i]->cda,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->sta,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->rda,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->acda,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->asta,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->ita,0) }} </td>
                <td style="text-align:right" width="5%">{{ number_format($data[$i]->dtduty,0) }} </td> --}}
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->pndpkgs,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->pndwt,0) }} </td>
                <td style="text-align:right" width="6%">{{ number_format($data[$i]->pndval,0) }} </td>
    @endif



            </tr>
            @endfor

            {{-- {{ $vbund += $data[$i]->dpackingwt }}
            {{ $vwt += $data[$i]->dtwt }}
            {{ $vcd += $data[$i]->cda }}
            {{ $vst += $data[$i]->sta }}
            {{ $vrd += $data[$i]->rda }}
            {{ $vacd += $data[$i]->acda }}
            {{ $vast += $data[$i]->asta }}
            {{ $vit += $data[$i]->ita }}
            {{ $vtotal += $data[$i]->dtduty }} --}}




            <tr>
                {{-- <td class="column-headers" colspan="11" width="3%" style="text-align: right;font-weight: bold; border-bottom: 1px solid lightgray;">Grand Total</td> --}}
                <td colspan="12"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vbund,0) }} </td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vwt,0) }} </td>
                {{-- <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vcd,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vst,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vrd,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vacd,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vast,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vit,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($vtotal,0) }} </td> --}}
                <td colspan="3"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold"> </td>
                {{-- <td colspan="17" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($rpcs,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($rwt,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($rfeet,0) }} </td>

                <td colspan="1" width="3%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($ppcs,0) }} </td>
                <td colspan="1" width="3%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($pwt,0) }} </td>
                <td colspan="1" width="3%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($pfeet,0) }} </td> --}}

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
