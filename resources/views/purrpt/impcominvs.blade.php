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
    font-size: 0.7rem;
    margin-top:3px;
    margin-bottom:3px;
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
                    <span style="font-size:2rem">Import Purchase Invoice</span>
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

    <table class="ledger">
        <tbody>
            <tr>

                <td>
                    Contract No
                </td>
                <td>
                    {{ $data[0]->contract_id }}
                </td>



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
                    {{ $data[0]->invoiceno }}
                </td>
                <td>
                    Invoice Date
                </td>
                <td>
                    {{ $data[0]->invoice_date }}
                </td>
                <td>
                    Insurance
                </td>
                <td>
                    {{ $data[0]->insurance }}
                </td>


            </tr>
            <tr>

                <td>
                    GD No
                </td>
                <td>
                    {{ $data[0]->machineno }}
                </td>

                <td>
                    GD Date
                </td>
                <td>
                    {{ $data[0]->machine_date }}
                </td>

                <td>
                    Sup.Conv.Rate
                </td>
                <td>
                    {{ $data[0]->sconversionrate }}
                </td>
                <td>
                    Dut.Conv.Rate
                </td>
                <td>
                    {{ $data[0]->conversionrate }}
                </td>
                <td>
                    Tot Inv.Level Chrgs
                </td>
                <td>
                    {{ $data[0]->tinvschrgs }}
                </td>






            </tr>
        </tbody>
    </table>




    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            {{-- <tr> <th class="column-headers" width="50%">OPENING BNALANCE</th></tr> --}}
            <tr>
                <td colspan="3" width="13%" style="  text-align:center;font-weight: bold; font-size: 0.9rem;border-right: 1px solid lightgray;"> Material Description</td>
                <td colspan="7" width="17%" style="text-align:center;font-weight: bold; font-size: 0.9rem;border-right: 1px solid lightgray;"> Receiving Data For Supplier</td>
                <td colspan="3" width="8%" style="text-align: center;font-weight: bold; font-size: 0.9rem;border-right: 1px solid lightgray;">For Commercial Invoice</td>

                <td colspan="4" width="11%" style="text-align: center;font-weight: bold; font-size: 0.9rem;border-right: 1px solid lightgray;">For Commercial Duty</td>
                <td colspan="2" width="2%" style="text-align: center;font-weight: bold; font-size: 0.9rem;border-right: 1px solid lightgray;">Insurance</td>


                <td colspan="1" width="4%" style="text-align: center;font-weight: bold; font-size: 0.9rem;border-right: 1px solid lightgray;">Value</td>
                <td colspan="1" width="3%" style="text-align: center;font-weight: bold; font-size: 0.9rem;border-right: 1px solid lightgray;">1%</td>


                <td colspan="1" width="3%" style="text-align: center;font-weight: bold; font-size: 0.9rem;border-right: 1px solid lightgray;">InvLvl</td>
                <td colspan="1" width="3%" style="text-align: center;font-weight: bold; font-size: 0.9rem;border-right: 1px solid lightgray;">L.Cost</td>
                <td colspan="8" width="24%" style="text-align: center;font-weight: bold; font-size: 0.9rem;border-right: 1px solid lightgray;">Duties</td>
                <td colspan="1" width="3%" style="text-align: center;font-weight: bold; font-size: 0.9rem;border-right: 1px solid lightgray;">Total</td>

                <td colspan="3" width="9%" style="text-align: center;font-weight: bold; font-size: 0.9rem;border-right: 1px solid lightgray;">Costing</td>
            </tr>

            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="column-headers" width="1%">S#</th>
                    <th class="column-headers" width="9%">Material Name</th>
                    <th class="column-headers" width="3%">Size</th>


                    {{-- For Supplier --}}
                    <th class="column-headers" width="2%">Weight</th>
                    <th class="column-headers" width="2%">Pcs</th>
                    <th class="column-headers" width="1%">Len</th>
                    <th class="column-headers" width="3%">Feet</th>
                    <th class="column-headers" width="2%">Price</th>
                    <th class="column-headers" width="3%">Val($)</th>
                    <th class="column-headers" width="4%">Val(pkr)</th>


                    {{-- For commercial invoice --}}
                    <th class="column-headers" width="2%">Price</th>
                    <th class="column-headers" width="3%">Val($)</th>
                    <th class="column-headers" width="3%">Val(pkr)</th>
.
                    {{-- For commercial Duty --}}
                    <th class="column-headers" width="2%">Weight</th>
                    <th class="column-headers" width="2%">Price</th>
                    <th class="column-headers" width="3%">Val($)</th>
                    <th class="column-headers" width="4%">Val(pkr)</th>

                    {{-- For insurance --}}
                    <th class="column-headers" width="1%">Ratio%</th>
                    <th class="column-headers" width="1%">Val($)</th>
                    <th class="column-headers" width="4%">W/Ins.</th>
                    <th class="column-headers" width="3%">Duty</th>


                    <th class="column-headers" width="3%">chrgs</th>
                    <th class="column-headers" width="3%">w/o dty</th>





                    {{-- For insurance --}}
                    <th class="column-headers" width="3%">CDA</th>
                    <th class="column-headers" width="3%">STA</th>
                    <th class="column-headers" width="3%">RDA</th>
                    <th class="column-headers" width="3%">ACDA</th>
                    <th class="column-headers" width="3%">ASTA</th>
                    <th class="column-headers" width="3%">ITA</th>
                    <th class="column-headers" width="2%">WSE</th>
                    <th class="column-headers" width="4%">TotDuty</th>

                    <th class="column-headers" width="3%">L.Cost</th>

                    <th class="column-headers" width="3%">Per/Pc</th>
                    <th class="column-headers" width="3%">PerKg</th>
                    <th class="column-headers" width="3%">PerFeet</th>


            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>

            {{ $owt = 0 }};{{ $opcs = 0 }}; {{ $ofeet = 0 }}; {{ $svaldlr = 0 }};{{ $svalpkr = 0 }};
            {{ $invsvaldlr = 0 }};{{ $invsvalpkr = 0 }};
            {{ $cwt = 0 }};{{ $cinvsvaldlr = 0 }};{{ $cinvsvalpkr = 0 }};
            {{ $insvaldlr = 0 }};{{ $insvalrup = 0 }};{{ $insval1per = 0 }}
            {{ $invslvlch = 0 }};{{ $tlc = 0 }};
            {{ $vcda = 0 }};{{ $vsta = 0 }};{{ $vrda = 0 }};{{ $vacda = 0 }};{{ $vasta = 0 }};{{ $vita = 0 }};{{ $vwsca = 0 }};{{ $vtotduty = 0 }}

            {{ $gtlc = 0 }}


            @for ($i = 0 ; $i < count($data) ; $i++)
            @if( $i==0 )
            <tr>
                <td colspan="35" width="100%" style="text-align: left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
            </tr>
        @else

        {{ $srno = $i - 1 }}
        @if ($data[$i]->Itemgroupe  <> $data[$srno]->Itemgroupe)
            <tr>
                    <td colspan="35" width="100%" style="text-align:left;font-size:1.2rem;border-bottom: 2px solid rgb(211, 211, 211);"> {{ $data[$i]->Itemgroupe}} </td>
             </tr>
        @endif
        @endif


            <tr>

                {{ $owt += $data[$i]->supwt }};{{ $opcs += $data[$i]->pcs }};{{ $ofeet += $data[$i]->qtyinfeet }} ;{{ $svaldlr += $data[$i]->supvaldlr }};{{ $svalpkr += $data[$i]->supvalrup }}
                {{ $invsvaldlr += $data[$i]->invsvaldlr }};{{ $invsvalpkr += $data[$i]->invsvalrup }}
                {{ $cwt += $data[$i]->dutygdswt }};{{ $cinvsvaldlr += $data[$i]->dtyvaldlr }};{{ $cinvsvalpkr += $data[$i]->dtyvalrup }}
                {{ $insvaldlr += $data[$i]->insdlr }};{{ $insvalrup += $data[$i]->insrup }};{{ $insval1per += $data[$i]->oneperduty }}
                {{ $invslvlch += $data[$i]->invlvlchrgs }};{{ $tlc += $data[$i]->pricevaluecostsheet }}

                {{ $vcda += $data[$i]->cda }}; {{ $vsta += $data[$i]->sta }}; {{ $vrda += $data[$i]->rda }}; {{ $vacda += $data[$i]->acda }};
                {{ $vasta += $data[$i]->asta }}; {{ $vita += $data[$i]->ita }}; {{ $vwsca += $data[$i]->wsca }}; {{ $vtotduty += $data[$i]->totduty }};

                {{ $gtlc += $data[$i]->totallccostwexp }}



                <td style="text-align:center; font-size: 0.6rem" width="1%">{{ $i+1 }}</td>
                <td style="text-align:left; font-size: 0.6rem" width="9%">{{ $data[$i]->matname}} </td>
                <td style="text-align:center; font-size: 0.6rem" width="3%">{{ $data[$i]->size}} </td>

                <td style="text-align:right; font-size: 0.6rem" width="2%">{{ number_format($data[$i]->supwt,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="2%">{{ number_format($data[$i]->pcs,0) }} </td>
                <td style="text-align:center; font-size: 0.6rem" width="1%">{{ number_format($data[$i]->itmlen,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->qtyinfeet,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="2%">{{ number_format($data[$i]->supprice,1) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->supvaldlr,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="4%">{{ number_format($data[$i]->supvalrup,0) }} </td>


                <td style="text-align:right; font-size: 0.6rem" width="2%">{{ number_format($data[$i]->invsrate,1) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->invsvaldlr,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->invsvalrup,0) }} </td>



                <td style="text-align:right; font-size: 0.6rem" width="2%">{{ number_format($data[$i]->dutygdswt,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="2%">{{ number_format($data[$i]->dtyrate,1) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->dtyvaldlr,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="4%">{{ number_format($data[$i]->dtyvalrup,0) }} </td>


                <td style="text-align:right; font-size: 0.6rem" width="1%">{{ number_format($data[$i]->itmratio,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="1%">{{ number_format($data[$i]->insdlr,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="4%">{{ number_format($data[$i]->insrup,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->oneperduty,0) }} </td>


                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->invlvlchrgs,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->pricevaluecostsheet,0) }} </td>




                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->cda,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->sta,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->rda,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->acda,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->asta,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->ita,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="2%">{{ number_format($data[$i]->wsca,0) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="4%">{{ number_format($data[$i]->totduty,0) }} </td>

                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->totallccostwexp,0) }} </td>


                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->perpc,1) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->perkg,1) }} </td>
                <td style="text-align:right; font-size: 0.6rem" width="3%">{{ number_format($data[$i]->perft,1) }} </td>







            </tr>
            @endfor
            <tr>
                {{-- <td colspan="3" width="15%" style="text-align: right;border-bottom: 1px solid lightgray;">Grand Total</td> --}}
                <td colspan="4" width="2%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($owt,0) }} </td>
                <td colspan="1" width="2%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($opcs,0) }} </td>
                <td colspan="2" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($ofeet,0) }} </td>

                <td colspan="2" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($svaldlr,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($svalpkr,0) }} </td>

                <td colspan="2" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($invsvaldlr,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($invsvalpkr,0) }} </td>

                <td colspan="1" width="2%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($cwt,0) }} </td>
                <td colspan="2" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($cinvsvaldlr,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($cinvsvalpkr,0) }} </td>

                <td colspan="2" width="1%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($insvaldlr,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($insvalrup,0) }} </td>
                <td colspan="1" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($insval1per,0) }} </td>

                <td colspan="1" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($invslvlch,0) }} </td>
                <td colspan="1" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($tlc,0) }} </td>


                <td colspan="1" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($vcda,0) }} </td>
                <td colspan="1" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($vsta,0) }} </td>
                <td colspan="1" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($vrda,0) }} </td>
                <td colspan="1" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($vacda,0) }} </td>
                <td colspan="1" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($vasta,0) }} </td>
                <td colspan="1" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($vita,0) }} </td>
                <td colspan="1" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($vwsca,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($vtotduty,0) }} </td>
                <td colspan="1" width="3%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;">{{ number_format($gtlc,0) }} </td>
                <td colspan="3" width="9%" style="text-align: right;font-weight: bold;background: #e3e3e3; font-size: 0.6rem;border-bottom: 1px solid lightgray;"> </td>




                {{-- <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($pwt,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($ppcs,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($pfeet,0) }} </td>

                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($swt,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($spcs,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($sfeet,0) }} </td>

                <td colspan="7" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($cwt,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($cpcs,0) }} </td>
                <td colspan="1" width="4%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($cfeet,0) }} </td> --}}


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
