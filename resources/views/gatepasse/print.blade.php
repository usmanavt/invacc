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
                    <span style="font-size:2.5rem;font-weight: bold;">GATE PASS</span>

                </td>
            </tr>
        </tbody>
    </table>

    <table class="hd1" >
        <tbody>
              <tr>
                <td>
                    {{-- <span style="font-size:2rem;">{{ $hdng1 }}</span> --}}
                    <h1>MUHAMMAD NAZIR & Co</h1>
                </td>
            </tr>
        </tbody>
    </table>

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
        </tbody>
    </table>




    {{-- Ledger Info --}}

    <table style="Padding:5px; border:1.5px solid burlywood; "  >
        <tbody>
            <tr>
                <td >P.O No:  <span style="font-weight: bold"> {{ $data[0]->pono }}</span>
                <td >P.O Date:  <span style="font-weight: bold"> {{ $data[0]->podate }}</span>
                <td >G.Pass No:  <span style="font-weight: bold"> {{ $data[0]->gpno }}</span>
                <td >G.Pass Date:  <span style="font-weight: bold"> {{ $data[0]->gpdate }}</span>
            </tr>
        </tbody>
    </table>

    <table style="Padding:5px; border:1.5px solid burlywood; "  >
        <tbody>
            <tr>
                <td >Vehicle No:  <span style="font-weight: bold"> {{ $data[0]->vehno }}</span>
                <td >Driver Name:  <span style="font-weight: bold"> {{ $data[0]->drvrname }}</span>
                <td >Driver Tel.No:  <span style="font-weight: bold"> {{ $data[0]->drvrtelno }}</span>
                <td >Departure Time:  <span style="font-weight: bold"> {{ $data[0]->deptime }}</span>
            </tr>
        </tbody>
    </table>






    <table style="Padding:3px; border:1.5px solid burlywood; "  >
        <tbody>
            <tr >
                <td > Customer Name:  <span style="font-weight: bold"> {{ $data[0]->custname }}</span>
            </tr>
            <tr >
                <td > Address:  <span style="font-weight: bold"> {{ $data[0]->custadrs }}</span> </td>
            </tr>


        </tbody>
    </table>





    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            <tr >
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th   width="4%">S#</th>
                    <th width="58%">Goods Description</th>
                    <th width="8%">Unit</th>
                    {{-- <th width="15%">Brand</th> --}}
                    <th width="10%">Weight</th>
                    <th  width="10%">Pcs</th>
                    <th  width="10%">Feet</th>

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
                {{ $tqty = 0 }}

                @for ($i = 0 ; $i < count($data) ; $i++)
                    @if ($data[$i]->grpid  == 1)
                        <tr>
                            {{-- {{ $tqty += $data[$i]->qty }} --}}
                            <td style="font-size:12px;text-align:center" width="4%">{{ $i+1 }}</td>
                            <td style="font-size:12px" width="58%">{{ $data[$i]->matname }} </td>
                            <td style="text-align:center;font-size:12px" width="8%">{{ $data[$i]->UOM }} </td>
                            {{-- <td style="text-align:left;font-size:12px" width="15%">{{ $data[$i]->mybrand }} </td> --}}
                            <td style="text-align:right;font-size:12px" width="10%">{{ number_format($data[$i]->swt,1) }} </td>
                            <td style="font-size:12px" width="10%">{{ number_format($data[$i]->spcs,1) }} </td>
                            <td style="text-align:right;font-size:12px" width="10%">{{ number_format($data[$i]->sfeet,0) }} </td>
                        </tr>
                    @endif
                @endfor
                <tr>
                    <td colspan="6" width="100%" style="text-align: right;border-bottom: 1px solid lightgray;"></td>
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

            <table class="data1" >

                <tbody>
                    {{ $vvlues = 0 }}
                    @for ($i = 0 ; $i < count($data) ; $i++)
                        @if ($data[$i]->grpid  > 1 and $data[$i]->grpid <>5 )
                            <tr>
                                {{-- {{ $vvlues += $data[$i]->saleamnt }} --}}
                                <td style="font-size:12px" width="4%">{{ $i+1 }}</td>
                                <td style="font-size:12px;border-right: 1.5px solid burlywood;font-weight: bold;" width="40%">{{ $data[$i]->matname }} </td>
                                <td style="text-align:center;font-size:12px ;font-weight: bold;" width="7%">{{ $data[$i]->UOM }} </td>
                                <td style="text-align:left;font-size:12px;border-right: 1.5px solid burlywood;font-weight: bold;" width="20%">{{ $data[$i]->mybrand }} </td>
                                <td style="text-align:right;font-size:12px;border-right: 1.5px solid burlywood;font-weight: bold;" width="9%">{{ number_format($data[$i]->swt,1) }} </td>
                                <td style="text-align:right;font-size:12px;border-right: 1.5px solid burlywood;font-weight: bold;" width="9%">{{ number_format($data[$i]->spcs,1) }} </td>
                                <td style="text-align:right;font-size:12px;font-weight: bold" width="11%">{{ number_format($data[$i]->sfeet,0) }} </td>

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
