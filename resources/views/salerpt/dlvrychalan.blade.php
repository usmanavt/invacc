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
    /* border:1px solid lightgray;
    background: #e3e3e3;
    margin-top:5px;
    margin-bottom:5px;
    border-bottom: 2px double gray; */

    border:1px solid black;
    border-left: 1px solid black;
    border-right: 1px solid black;
    background: #e3e3e3;
    font-size: 1rem;
    margin-top:5px;
    /* margin-bottom:5px; */
    border-collapse: collapse;

}
/* .column-headers th{
    text-align: center;
} */

.data1{

    border:1.5px solid burlywood;
    /* border-collapse: collapse; */
     padding:5px;
}



.data {
    border-collapse: collapse;
}

.hd1{

    border-left: 1px solid black;
    border-right: 1px solid black;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
    text-align: center;
    /* font-weight: bold; */
    /* font-size: 2rem; */
    font-style: normal;
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


</style>
</head>
    <body>
{{-- https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages?answertab=votes#tab-top --}}

    {{-- Report Header --}}

    <table class="hd1">
        <tbody>
              <tr>
                <td >
                    <span style="font-size:2.5rem;font-weight: bold;">DELIVERY CHALLAN</span>

                </td>
            </tr>
        </tbody>
    </table>

    <table class="hd1" >
        <tbody>
              <tr>
                <td>
                    <span style="font-size:2rem;">{{ $hdng1 }}</span>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="hd1" >
        <tbody>
              <tr >
                <td style="Padding:5px 130px 30px 130px " >
                    <span style= "font-size:1rem;font-weight: bold">{{ $hdng2 }}</span>
                </td>
            </tr>
        </tbody>
    </table>




    {{-- Ledger Info --}}
    <table >
        <tbody>
            <tr class="hd1">
                <td > Customer Name:</td>
                <td align ="left" style="font-size:12px;font-weight: bold" > {{ $data[0]->custname }}</td>
                <td> Address:</td>
                <td align ="left" style="font-size:12px;font-weight: bold" > {{ $data[0]->custadrs }}</td>
           </tr>




            <tr>
                <td>P.O No:</td>
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
            {{-- </tr> --}}
                {{-- <tr> --}}
                    <td>
                        D.C No:
                    </td>
                    <td align ="left" style="font-size:12px;font-weight: bold">
                        {{-- From {{ $fromdate }} to {{ $todate }} --}}
                        {{ $data[0]->dcno }}
                    </td>

                    <td>
                        Delivery Date:
                    </td>
                    <td align ="left" style="font-size:12px;font-weight: bold">
                        {{ $data[0]->saldate }}
                    </td>
                </tr>
        </tbody>
    </table>
    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th  width="6%">S#</th>
                    {{-- <th class="" width="16%">Group Name</th> --}}
                    <th width="52%">Material Name</th>
                    <th width="8%">Unit</th>
                    <th width="20%">Brand</th>
                    <th width="14%">Quantity</th>
                    {{-- <th class="" width="9%">Price</th> --}}
                    {{-- <th class="" width="11%">Amount</th> --}}

            </tr>
        </thead>
    </table>

    <div style="height:700px;border:1px solid;">

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
                {{ $tqty = 0 }}

                @for ($i = 0 ; $i < count($data) ; $i++)
                    @if ($data[$i]->grpid  == 1)
                        <tr>
                            {{ $tqty += $data[$i]->qty }}
                            <td style="font-size:12px;text-align:center" width="6%">{{ $i+1 }}</td>
                            {{-- <td class="" width="16%">{{ $data[$i]->grpname }} </td> --}}
                            <td style="font-size:12px" width="52%">{{ $data[$i]->matname }} </td>
                            <td style="text-align:center;font-size:12px" width="8%">{{ $data[$i]->UOM }} </td>
                            <td style="text-align:left;font-size:12px" width="20%">{{ $data[$i]->mybrand }} </td>
                            <td style="font-size:12px" width="14%">{{ number_format($data[$i]->qty,1) }} </td>
                            {{-- <td style="font-size:12px" width="9%">{{ number_format($data[$i]->price,1) }} </td> --}}
                            {{-- <td style="text-align:right;font-size:12px" width="11%">{{ number_format($data[$i]->saleamnt,0) }} </td> --}}
                        </tr>
                    @endif
                @endfor
                <tr>
                    <td colspan="8" width="100%" style="text-align: right;border-bottom: 1px solid lightgray;"></td>
                    {{-- <td colspan="4" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vtotpcs,0) }} </td> --}}
                    {{-- <td class="1" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vwt,0) }} </td> --}}
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


            </div>


        {{-- </div> --}}
        {{-- <div style="margin-top:750px;"> --}}

        {{-- <table > --}}

            <div style="margin-top:80px;">
            <table>
                <tbody>

                    <tr style="margin-top:14px;margin-bottom:16px;" >
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
