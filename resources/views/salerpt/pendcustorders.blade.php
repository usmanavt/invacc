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
        <tbody><tr><td> PENDING PURCHASE ORDER </td></tr></tbody>
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

    <table style="Padding:5px; border:1.5px solid burlywood; "  >
        <tbody>
            <tr>

                <td >Quotation Date:  <span style="font-weight: bold"> {{ $data[0]->qutdate }}</span>
                <td >Quotation No:  <span style="font-weight: bold"> {{ $data[0]->pqutno }}</span>
                <td >P.O No:  <span style="font-weight: bold"> {{ $data[0]->pono }}</span>
                <td >P.O Date:  <span style="font-weight: bold"> {{ $data[0]->podate }}</span>
                <td >Delivery Date:  <span style="font-weight: bold">{{ $data[0]->deliverydt }}</span>
            </tr>
        </tbody>
    </table>




    {{-- Ledger Info --}}
    {{-- <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Qut.Date:
                </td>
                <td align ="left" style="font-size:12px;font-weight: bold"  >
                    {{ $data[0]->qutdate }}
                </td>
                <td>
                    Qut.No:
                </td>
                <td align ="left" style="font-size:12px;font-weight: bold"  >
                    {{ $data[0]->pqutno }}
                </td>

                <td>
                    P.O No:
                </td>
                <td align ="left" style="font-size:12px;font-weight: bold"  >
                    {{ $data[0]->pono }}
                </td>
                <td >
                    P.O Date:
                </td>
                <td align ="left" style="font-size:12px;font-weight: bold">
                    {{ $data[0]->podate }}
                </td>
                    <td>
                        Dlvry.Date:
                    </td>
                    <td align ="left" style="font-size:12px;font-weight: bold">
                        {{ $data[0]->deliverydt }}
                    </td>
                </tr>
        </tbody>
    </table> --}}
    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="" width="3%">S#</th>
                    {{-- <th class="" width="16%">Group Name</th> --}}
                    <th class="" width="30%">Goods Description</th>
                    <th class="" width="7%">Unit</th>
                    <th class="" width="15%">Brand</th>
                    <th class="" width="9%">Order<br>Quantity </th>
                    <th class="" width="9%">Price</th>
                    <th class="" width="9%">Order<br>Amount </th>
                    <th class="" width="9%">Balance<br>Quantity  </th>
                    <th class="" width="9%">Balance<br>Amount </th>

            </tr>
        </thead>
    </table>

    <div style="height:500px;border:1px solid;">

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
                {{ $vordamount = 0 }}
                {{ $vbamount = 0 }}


                @for ($i = 0 ; $i < count($data) ; $i++)
                    @if ($data[$i]->grpid  == 1)
                        <tr>
                            {{ $vordamount += $data[$i]->saleamnt }}
                            {{ $vbamount += $data[$i]->balamount }}


                            <td class="text-align:center;font-size:12px" width="4%">{{ $i+1 }}</td>
                            {{-- <td class="" width="16%">{{ $data[$i]->grpname }} </td> --}}
                            <td style="font-size:12px" width="35%">{{ $data[$i]->matname }} </td>
                            <td style="text-align:center;font-size:12px" width="7%">{{ $data[$i]->UOM }} </td>
                            <td style="text-align:left;font-size:12px" width="15%">{{ $data[$i]->mybrand }} </td>
                            <td style="font-size:12px" width="9%">{{ number_format($data[$i]->qty,1) }} </td>
                            <td style="font-size:12px" width="9%">{{ number_format($data[$i]->price,1) }} </td>
                            <td style="text-align:right;font-size:12px" width="11%">{{ number_format($data[$i]->saleamnt,0) }} </td>
                            <td style="text-align:right;font-size:12px;color:brown;font-weight: bold" width="10%">{{ number_format($data[$i]->balqty,0) }} </td>
                            <td style="text-align:right;font-size:12px;color:brown;font-weight: bold" width="10%">{{ number_format($data[$i]->balamount,0) }} </td>
                        </tr>
                    @endif
                @endfor
                <tr>
                    <td colspan="2"  style="text-align:right;font-size:12px;font-weight: bold;border-bottom: 1px solid lightgray;background: #e3e3e3;">Total</td>
                    <td colspan="5"  style="text-align:right;font-size:12px;font-weight: bold;border-bottom: 1px solid lightgray;background: #e3e3e3;">{{ number_format($vordamount,0) }} </td>
                    <td colspan="5"  style="text-align:right;font-size:12px;font-weight: bold;border-bottom: 1px solid lightgray;background: #e3e3e3;">{{ number_format($vbamount,0) }} </td>
                    {{-- <td class="2" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vvlues,0) }} </td> --}}
               </tr>

            </tbody>

        </table>
    </div>


    {{-- Footer  --}}
    {{-- <div style="margin-top:64px;"> --}}

        <div style="margin-top:10px;">

            {{-- <table>
                <tbody>
                      <tr>
                        <td  style="text-align: left;">
                            <span style="font-size:1.5rem;font-weight: bold">SUMMARY</span>
                        </td>
                    </tr>
                </tbody>
            </table> --}}

            <table class="data1" >

                <tbody>
                    {{ $vvlues = 0 }}
                    @for ($i = 0 ; $i < count($data) ; $i++)
                        @if ($data[$i]->grpid  > 1)
                            <tr>
                                {{ $vvlues += $data[$i]->saleamnt }}
                                <td style="font-size:12px;text-align:center" width="4%">{{ $i+1 }}</td>
                                {{-- <td class="" width="16%">{{ $data[$i]->grpname }} </td> --}}
                                <td style="font-size:12px;border-right: 1.5px solid burlywood;font-weight: bold;" width="35%">{{ $data[$i]->matname }} </td>
                                <td style="text-align:center;font-size:12px ;font-weight: bold;" width="7%">{{ $data[$i]->UOM }} </td>
                                {{-- <td style="text-align:left;font-size:12px;border-right: 1.5px solid burlywood;font-weight: bold;" width="15%">{{ $data[$i]->mybrand }} </td>
                                <td style="text-align:right;font-size:12px;border-right: 1.5px solid burlywood;font-weight: bold;" width="9%">{{ number_format($data[$i]->qty,1) }} </td>
                                <td style="text-align:right;font-size:12px;border-right: 1.5px solid burlywood;font-weight: bold;" width="9%">{{ number_format($data[$i]->price,1) }} </td>
                                <td style="text-align:right;font-size:12px;font-weight: bold" width="10%">{{ number_format($data[$i]->balqty,0) }} </td> --}}
                                <td style="text-align:right;font-size:12px;font-weight: bold" width="11%">{{ number_format($data[$i]->saleamnt,0) }} </td>

                            </tr>
                        @endif
                    @endfor

                    {{-- border:1px solid burlywood; --}}


                    {{-- <h3 style="font-size:1rem">Term and condition: {{ $hdng3 }}</h3> --}}
                </tbody>
                </table>
            </div>


        {{-- </div> --}}
        {{-- <div style="margin-top:750px;"> --}}

        {{-- <table > --}}








            <div style="margin-top:100px;">
            <table>
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
        </table>
    </body>
</html>
