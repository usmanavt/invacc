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

body{
    /* border:1px solid lightgray; */
    padding:30px;
    /* width: 100%; */
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
    border-bottom: 2px double gray;
}
.column-headers th{
    text-align: center;
}

.data1{

    border:1.5px solid burlywood;
    /* border-collapse: collapse; */
     padding:5px;
}



.data {
    border-collapse: collapse;
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

/* styles.css */

.mhd
{

font-size: 2.5rem;
border:3px solid black;
padding-top: 3px;
padding-left: 8px;

}
</style>
</head>



<body>
{{-- https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages?answertab=votes#tab-top --}}

    {{-- Report Header --}}

    <table class="mhd">
        <tbody><tr><td> COMPLETED PRICE QUITATION </td></tr></tbody>
    </table>


    {{-- align ="left" style="width:100%;" --}}
    <table  >
        <tbody  >

            <tr style="width:100%;"  >
                <td  style="width:60%;font-size:32px;" >  From  :  </td>
                <td style="width:10%;font-size:32px;"  > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                <td  style="width:30;font-size:32px;" > To  :  </td>

            </tr>
            <tr align ="left" style="width:100%;"  >
                <td align ="left" style="width:100%;font-size:32px;">
                    <h3> {{ $hdng1 }} </h3>
                    <h6> {{ $hdng2 }} </h6>
                    {{-- <h6> {{ $hdng2 }} </h6> --}}
                </td>
                <td style="width:10%;font-size:32px;"  > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                <td align ="left" style="width:100%;font-size:32px;vertical-align: top;">
                    <h3> {{ $data[0]->custname }} </h3>
                    <h6> {{ $data[0]->custadrs }} </h6>
                    {{-- <h6> {{ $hdng2 }} </h6> --}}

                </td>

.            </tr>
    </tbody>
    </table>

    {{-- <table align ="right" style="width:50%;">
        <tbody >

            <tr> <td> <h2> to  : </h2> </td> </tr>
            <tr  >
                <td align ="left" style="width:20%;">
                    <h2> {{ $data[0]->custname }} </h2>
               </td>
             </tr>
    </tbody>
    </table> --}}

    {{-- Address --}}


    {{-- Ledger Info --}}

    <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Quotation No:
                </td>
                <td align ="left" style="font-size:12px;font-weight: bold"  >
                    {{ $data[0]->qutno }}
                </td>
                <td >
                    Quotation Date:
                </td>
                <td align ="left" style="font-size:12px;font-weight: bold">
                    {{ $data[0]->qutdate }}
                </td>
                <td>
                    P.R No:
                </td>
                <td align ="left" style="font-size:12px;font-weight: bold">
                    {{-- From {{ $fromdate }} to {{ $todate }} --}}
                    {{ $data[0]->prno }}
                </td>

                <td>
                    Valid Date:
                </td>
                <td align ="left" style="font-size:12px;font-weight: bold">
                    {{ $data[0]->valdate }}
                </td>
            </tr>
        </tbody>
    </table>




    {{-- column headers --}}
    <table class="column-headers ">
        <thead >

            <tr>
                <td colspan="3" width="19%" style="font-size:09px;  text-align:center;font-weight: bold;border: 1px solid black;"> Material Description</td>
                <td colspan="3" width="20%" style=" font-size:09px; text-align:center;font-weight: bold;border: 1px solid black;"> Quotation</td>
                <td colspan="5" width="9%" style=" font-size:09px; text-align: center;font-weight: bold;border: 1px solid black;"> Purchase Order</td>
                <td colspan="5" width="9%" style=" font-size:09px; text-align: center;font-weight: bold;border: 1px solid black;"> Sale Invoice</td>
                <td colspan="2" width="9%" style=" font-size:09px; text-align: center;font-weight: bold;border: 1px solid black;"> Pending</td>
            </tr>

            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th style="font-size:08px ;border: 1px solid black; "  width="2%">S#</th>
                    <th style="font-size:08px ;border: 1px solid black; " width="17%">Material Name</th>
                    <th style="font-size:08px ;border: 1px solid black;" width="3%">Unit</th>

                    {{-- Quotation Data --}}
                    <th style="font-size:08px ;border: 1px solid black;" width="5%">Qty</th>
                    <th style="font-size:08px ;border: 1px solid black;" width="5%">Price</th>
                    <th style="font-size:08px ;border: 1px solid black;" width="6%">Amount</th>

                    {{-- P.O Data --}}
                    <th style="font-size:08px ;border: 1px solid black;" width="5%">P.O Date</th>
                    <th style="font-size:08px ;border: 1px solid black;" width="5%">P.O No</th>
                    <th style="font-size:08px ;border: 1px solid black;" width="5%">P.O Qty</th>
                    <th style="font-size:08px ;border: 1px solid black;" width="5%">Price</th>
                    <th style="font-size:08px ;border: 1px solid black;" width="6%">Amount</th>

                    {{-- Sale Data --}}
                    <th style="font-size:08px ;border: 1px solid black;" width="5%">Sale Date</th>
                    <th style="font-size:08px ;border: 1px solid black;" width="5%">D.C No</th>
                    <th style="font-size:08px ;border: 1px solid black;" width="5%">Sale Qty</th>
                    <th style="font-size:08px ;border: 1px solid black;" width="5%">Price</th>
                    <th style="font-size:08px ;border: 1px solid black;" width="6%">Amount</th>

                    <th style="font-size:08px ;border: 1px solid black;" width="5%">Quotation</th>
                    <th style="font-size:08px ;border: 1px solid black;" width="5%">P.O</th>



            </tr>
        </thead>
    </table>

    <div style="height:400px;border:1px solid;">

        {{-- <table>
            <tbody>
                  <tr>
                    <td  style="text-align: left;">
                        <span style="font-size:1.5rem;font-weight: bold">ITEM COST</span>
                    </td>
                </tr>
            </tbody>
        </table> --}}

        <table class="data" cellspacing="10">
            <tbody>
                {{ $vqutqty = 0 }};{{ $vqutamount = 0 }}
                {{ $vpoqty = 0 }};{{ $vpoamount = 0 }}
                {{ $vfeedqty = 0 }};{{ $vsaleamnt = 0 }}
                {{ $vqutbalqty = 0 }};{{ $vpobalqty = 0 }}


                @for ($i = 0 ; $i < count($data) ; $i++)
                    @if ($data[$i]->grpid  == 1)
                        <tr>
                            {{ $vqutqty += $data[$i]->qutqty }}; {{ $vqutamount += $data[$i]->qutamount }}
                            {{ $vpoqty += $data[$i]->poqty }}; {{ $vpoamount += $data[$i]->poamount }}
                            {{ $vfeedqty += $data[$i]->feedqty }}; {{ $vsaleamnt += $data[$i]->saleamnt }}
                            {{ $vqutbalqty += $data[$i]->qutbalqty }}; {{ $vpobalqty += $data[$i]->pobalqty }}


                            <td style="text-align:center;font-size:08px" width="2%">{{ $i+1 }}</td>
                            <td style="font-size:08px" width="17%">{{ $data[$i]->matname }} </td>
                            <td style="text-align:center;font-size:08px" width="3%">{{ $data[$i]->UOM }} </td>
                            <td style="text-align:right;font-size:08px" width="5%">{{ number_format($data[$i]->qutqty,1) }} </td>
                            <td style="text-align:right;font-size:08px" width="5%">{{ number_format($data[$i]->qutprice,1) }} </td>
                            <td style="text-align:right;font-size:08px" width="6%">{{ number_format($data[$i]->qutamount,0) }} </td>

                            <td style="text-align:center;font-size:08px" width="5%">{{ $data[$i]->podate }} </td>
                            <td style="text-align:center;font-size:08px" width="5%">{{ $data[$i]->pono }} </td>
                            <td style="text-align:right;font-size:08px" width="5%">{{ number_format($data[$i]->poqty,1) }} </td>
                            <td style="text-align:right;font-size:08px" width="5%">{{ number_format($data[$i]->poprice,1) }} </td>
                            <td style="text-align:right;font-size:08px" width="6%">{{ number_format($data[$i]->poamount,0) }} </td>

                            <td style="text-align:center;font-size:08px" width="5%">{{ $data[$i]->saldate }} </td>
                            <td style="text-align:center;font-size:08px" width="5%">{{ $data[$i]->dcno }} </td>
                            <td style="text-align:right;font-size:08px" width="5%">{{ number_format($data[$i]->feedqty,1) }} </td>
                            <td style="text-align:right;font-size:08px" width="5%">{{ number_format($data[$i]->price,1) }} </td>
                            <td style="text-align:right;font-size:08px" width="6%">{{ number_format($data[$i]->saleamnt,0) }} </td>

                            <td style="text-align:right;font-size:08px" width="5%">{{ number_format($data[$i]->qutbalqty,0) }} </td>
                            <td style="text-align:right;font-size:08px" width="5%">{{ number_format($data[$i]->pobalqty,0) }} </td>

                        </tr>
                    @endif
                @endfor
                <tr>
                    <td colspan="2"  style="text-align: right;font-size:08px;font-weight: bold;border-bottom: 1px solid lightgray;"> Total </td>
                    <td colspan="2"  style="text-align: right;font-size:08px;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vqutqty,0) }} </td>
                    <td colspan="2"  style="text-align: right;font-size:08px;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vqutamount,0) }} </td>

                    <td colspan="3"  style="text-align: right;font-size:08px;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vpoqty,0) }} </td>
                    <td colspan="2"  style="text-align: right;font-size:08px;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vpoamount,0) }} </td>

                    <td colspan="3"  style="text-align: right;font-size:08px;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vfeedqty,0) }} </td>
                    <td colspan="2"  style="text-align: right;font-size:08px;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vsaleamnt,0) }} </td>
                    <td colspan="1"  style="text-align: right;font-size:08px;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vqutbalqty,0) }} </td>
                    <td colspan="1"  style="text-align: right;font-size:08px;font-weight: bold;border-bottom: 1px solid lightgray;">{{ number_format($vpobalqty,0) }} </td>



                </tr>

            </tbody>

        </table>
    </div>


    {{-- Footer  --}}
    {{-- <div style="margin-top:64px;"> --}}

        {{-- <div style="margin-top:05px;">

            <table>
                <tbody>
                      <tr>
                        <td  style="text-align: left;">
                            <span style="font-size:1.5rem;font-weight: bold">SUMMARY</span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="data1" >

                <tbody>
                    {{ $vvlues = 0 }}
                    @for ($i = 0 ; $i < count($data) ; $i++)
                        @if ($data[$i]->grpid  > 1)
                            <tr>
                                {{ $vvlues += $data[$i]->saleamnt }}
                                <td class="" width="3%">{{ $i+1 }}</td>
                                <td style="font-size:12px" width="11%">{{ $data[$i]->matname }} </td>
                                <td style="text-align:center;font-size:12px" width="3%">{{ $data[$i]->UOM }} </td>
                                <td style="text-align:right;font-size:12px" width="6%">{{ number_format($data[$i]->qutqty,1) }} </td>
                                <td style="text-align:right;font-size:12px" width="5%">{{ number_format($data[$i]->qutprice,1) }} </td>
                                <td style="text-align:right;font-size:12px" width="6%">{{ number_format($data[$i]->qutamount,0) }} </td>

                                <td style="text-align:left;font-size:12px" width="5%">{{ $data[$i]->podate }} </td>
                                <td style="text-align:left;font-size:12px" width="5%">{{ $data[$i]->pono }} </td>
                                <td style="text-align:right;font-size:12px" width="6%">{{ number_format($data[$i]->poqty,1) }} </td>
                                <td style="text-align:right;font-size:12px" width="5%">{{ number_format($data[$i]->poprice,1) }} </td>
                                <td style="text-align:right;font-size:12px" width="6%">{{ number_format($data[$i]->poamount,0) }} </td>

                                <td style="text-align:left;font-size:12px" width="5%">{{ $data[$i]->saldate }} </td>
                                <td style="text-align:left;font-size:12px" width="5%">{{ $data[$i]->dcno }} </td>
                                <td style="text-align:right;font-size:12px" width="6%">{{ number_format($data[$i]->feedqty,1) }} </td>
                                <td style="text-align:right;font-size:12px" width="5%">{{ number_format($data[$i]->price,1) }} </td>
                                <td style="text-align:right;font-size:12px" width="6%">{{ number_format($data[$i]->saleamnt,0) }} </td>

                                <td style="text-align:right;font-size:12px" width="6%">{{ number_format($data[$i]->qutbalqty,0) }} </td>
                                <td style="text-align:right;font-size:12px" width="6%">{{ number_format($data[$i]->pobalqty,0) }} </td>

                            </tr>
                        @endif
                    @endfor
                    <h3 style="font-size:1rem">Term and condition: {{ $hdng3 }}</h3>
                </tbody>
                </table>
            </div> --}}


        {{-- </div> --}}
        {{-- <div style="margin-top:750px;"> --}}

        {{-- <table > --}}








            <div style="margin-top:100px;">
            {{-- <table>
                <tbody>

                    <tr style="margin-top:16px;margin-bottom:16px;" >
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
            </tbody>
        </table> --}}
    </body>
</html>
