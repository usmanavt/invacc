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
                    {{-- <h3 style="font-size:0.7rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                    <h3 style="font-size:0.7rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3>
                    <h3 style="font-size:0.7rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3> --}}
                    <h2 style="font-size:0.9rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes <br>
                        Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,<br>
                        Phone : 021-32588781, 021-32574285 , Fax : 021-32588782
                    </h2>

                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">GODOWN RECEIVING NOTE (LOCAL) </span>
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
                    Invoice No
                </td>
                <td>
                    {{ $data[0]->purinvsno }}
                </td>

                <td>
                    Invoice Date
                </td>
                <td>
                    {{ $data[0]->contract_date }}
                </td>

            </tr>
            <tr>
                {{-- <td>
                    Period
                </td>
                <td>
                    From {{ $fromdate }} to {{ $todate }}
                </td> --}}
                <td>
                    G.R No
                </td>
                <td>
                    {{ $data[0]->grno }}
                </td>

                <td>
                    G.R Date
                </td>
                <td>
                    {{ $data[0]->invoice_date }}
                </td>
                {{-- <td>
                    G.R Date
                </td>
                <td>
                    {{ $data[0]->invoice_date }}
                </td> --}}





            </tr>
        </tbody>
    </table>
    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            {{-- <tr> <th class="column-headers" width="50%">OPENING BNALANCE</th></tr> --}}
            <tr>
                <td colspan="4" width="23%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> Material Description</td>
                <td colspan="2" width="8%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> Contract Data</td>
                <td colspan="1" width="3%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Part</td>

                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">E - 13</td>
                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Gali No 2</td>
                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Allah Malik Shop</td>
                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">E - 24</td>
                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Bolton Shop</td>
                <td colspan="3" width="12%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Total Receiving</td>
                <td colspan="3" width="9%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Pending</td>

            </tr>

            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="column-headers" width="2%">S#</th>
                    <th class="column-headers" width="6%">Item Group</th>
                    <th class="column-headers" width="12%">Material Name</th>
                    <th class="column-headers" width="3%">Size</th>

                    <th class="column-headers" width="4%">Pcs</th>
                    <th class="column-headers" width="4%">Weight</th>

                    <th class="column-headers" width="3%">Length</th>

                    <th class="column-headers" width="3%">Pcs</th>
                    <th class="column-headers" width="3%">Weight</th>
                    <th class="column-headers" width="3%">Feet</th>

                    <th class="column-headers" width="3%">Pcs</th>
                    <th class="column-headers" width="3%">Weight</th>
                    <th class="column-headers" width="3%">Feet</th>


                    <th class="column-headers" width="3%">Pcs</th>
                    <th class="column-headers" width="3%">Weight</th>
                    <th class="column-headers" width="3%">Feet</th>

                    <th class="column-headers" width="3%">Pcs</th>
                    <th class="column-headers" width="3%">Weight</th>
                    <th class="column-headers" width="3%">Feet</th>

                    <th class="column-headers" width="3%">Pcs</th>
                    <th class="column-headers" width="3%">Weight</th>
                    <th class="column-headers" width="3%">Feet</th>

                    <th class="column-headers" width="4%">Pcs</th>
                    <th class="column-headers" width="4%">Weight</th>
                    <th class="column-headers" width="4%">Feet</th>

                    <th class="column-headers" width="3%">Pcs</th>
                    <th class="column-headers" width="3%">Weight</th>
                    <th class="column-headers" width="3%">Feet</th>




            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>

            {{ $cwt = 0 }};{{ $cpcs = 0 }};{{ $rwt = 0 }};{{ $rpcs = 0 }};{{ $rfeet = 0 }};{{ $pwt = 0 }};{{ $ppcs = 0 }};{{ $pfeet = 0 }}

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


            <tr>

                {{ $cwt += $data[$i]->gdswt }}.
                {{ $cpcs += $data[$i]->totpcs }}

                {{ $rwt += $data[$i]->purwttot }}
                {{ $rpcs += $data[$i]->purpcstot }}
                {{ $rfeet += $data[$i]->purfeettot }}

                {{ $pwt += $data[$i]->pendwt }}
                {{ $ppcs += $data[$i]->pendpcs }}
                {{ $pfeet += $data[$i]->pendfeet }}




                <td style="text-align:center" width="2%">{{ $i+1 }}</td>
                <td style="text-align:left" width="6%">{{ $data[$i]->category}} </td>
                <td style="text-align:left" width="12%">{{ $data[$i]->matname}} </td>
                <td style="text-align:center" width="3%">{{ $data[$i]->dimension}} </td>

                <td style="text-align:right" width="4%">{{ number_format($data[$i]->totpcs,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->gdswt,0) }} </td>
                <td style="text-align:right" width="3%">{{ $data[$i]->itemlen}} </td>

                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purpcse13,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purwte13,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purfeete13,0) }} </td>

                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purpcsgn2,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purwtgn2,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purfeetgn2,0) }} </td>

                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purpcsams,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purwtams,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purfeetams,0) }} </td>

                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purpcse24,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purwte24,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purfeete24,0) }} </td>


                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purpcsbs,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purwtbs,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->purfeetbs,0) }} </td>


                <td style="text-align:right" width="4%">{{ number_format($data[$i]->purpcstot,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->purwttot,0) }} </td>
                <td style="text-align:right" width="4%">{{ number_format($data[$i]->purfeettot,0) }} </td>

                <td style="text-align:right" width="3%">{{ number_format($data[$i]->pendpcs,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->pendwt,0) }} </td>
                <td style="text-align:right" width="3%">{{ number_format($data[$i]->pendfeet,0) }} </td>



            </tr>
            @endfor
            <tr>
                <td class="column-headers" colspan="4" width="3%" style="text-align: right;font-weight: bold; border-bottom: 1px solid lightgray;">Grand Total</td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($cpcs,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($cwt,0) }} </td>


                <td colspan="17" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($rpcs,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($rwt,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($rfeet,0) }} </td>

                <td colspan="1" width="3%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($ppcs,0) }} </td>
                <td colspan="1" width="3%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($pwt,0) }} </td>
                <td colspan="1" width="3%" style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($pfeet,0) }} </td>

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
