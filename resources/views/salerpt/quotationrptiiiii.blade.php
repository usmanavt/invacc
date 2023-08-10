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
.FlexContainer {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start;
    align-items: flex-start;
    align-content: flex-start;
    width: 100%;
    height:480px;
    overflow: auto;
    text-align: center;
    line-height: 30px;
    flex-direction: row;
    border:1px solid gray;
}
.rightly{
    align-content: flex-end;
    justify-content: flex-end;
    height:30px;
    width: 100%;
}
.bold{
    font-weight: bold;
}
.grayish{
    color: white;
    background-color: gray;
}
.FlexContainer .column1 {
    width: 5%;
    height: 30px;
    margin: 0px;
    border-bottom:1px solid gray;
    border-right:1px solid gray;
}
.FlexContainer .column2 {
    width: 35%;
    height: 30px;
    margin: 0px;
    border-bottom:1px solid gray;
}
.FlexContainer .column3 {
    width: 30%;
    height: 30px;
    margin: 0px;
    border-bottom:1px solid gray;
}
.FlexContainer .column4 {
    width: 8.33%;
    height: 30px;
    margin: 0px;
    border-bottom:1px solid gray;
    border-left:1px solid gray;
}

.FlexContainer .total2 {
    width: 8.33%;
    height: 30px;
    margin: 0px;
    border-bottom:1px solid gray;
    border-left:1px solid gray;
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
                    {{-- <h1>MUHAMMAD NAZIR & Co. </h1> --}}
                    <h1> {{ $hdng1 }} </h1>
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
                    {{ $hdng2 }}
                    {{-- <h3 style="font-size:0.7rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes & Tubes</h3> --}}
                    {{-- <h3 style="font-size:0.7rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3> --}}
                    {{-- <h3 style="font-size:0.7rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3> --}}
                </td>
            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:3rem;font-weight: bold">Sale Quotation</span>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Customer Name
                </td>
                <td>
                    {{ $data[0]->custname }}
                </td>
                <td>
                    Quotation No
                </td>
                <td>
                    {{ $data[0]->qutno }}
                </td>
                <td>
                    Quotation Date
                </td>
                <td>
                    {{ $data[0]->saldate }}
                </td>
            </tr>
                <tr>
                    <td>
                        P.R No
                    </td>
                    <td>
                        {{-- From {{ $fromdate }} to {{ $todate }} --}}
                        {{ $data[0]->prno }}
                    </td>

                    <td>
                        Valid Date
                    </td>
                    <td>
                        {{ $data[0]->valdate }}
                    </td>
                </tr>
        </tbody>
    </table>
    {{-- column headers --}}
    <div class="FlexContainer">
        <div class="column1 bold grayish">Sno</div>
        <div class="column2 bold grayish">Material</div>
        <div class="column1 bold grayish">Unit</div>
        <div class="column3 bold grayish">Brand</div>
        <div class="column4 bold grayish">Quantity</div>
        <div class="column4 bold grayish">Price</div>
        <div class="column4 bold grayish">Amount</div>

      {{ $vvlues = 0 }}
                @for ($i = 0 ; $i < count($data) ; $i++)
                    @if ($data[$i]->grpid  == 1)
                            {{ $vvlues += $data[$i]->saleamnt }}
                            <div class="column1">{{ $i+1 }}</div>
                            <div class="column2">{{ $data[$i]->matname }}</div>
                            <div class="column1">{{ $data[$i]->UOM }}</div>
                            <div class="column3">{{ $data[$i]->mybrand }}</div>
                            <div class="column4">{{ number_format($data[$i]->qty,1) }}</div>
                            <div class="column4">{{ number_format($data[$i]->price,1) }}</div>
                            <div class="column4">{{ number_format($data[$i]->saleamnt,0) }}</div>
                    @endif
                @endfor
                <!-- <tr>
                    <td colspan="8" width="100%" style="text-align: right;border-bottom: 1px solid lightgray;"></td>
                    {{-- <td colspan="4" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vtotpcs,0) }} </td> --}}
                    {{-- <td class="1" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vwt,0) }} </td> --}}
                    {{-- <td class="2" width="8%" style="text-align: right;border-bottom: 1px solid lightgray;">{{ number_format($vvlues,0) }} </td> --}}
               </tr> -->
    </div>
    <div class="FlexContainer rightly">
        {{ $vvlues = 0 }}
                @for ($i = 0 ; $i < count($data) ; $i++)
                    @if ($data[$i]->grpid  == 1)
                            {{ $vvlues += $data[$i]->saleamnt }}
        {{-- <div class="total2 bold grayish">{{ number_format($vtotpcs,0) }}</div> --}}
        {{-- <div class="total2 bold grayish">{{ number_format($vwt,0) }}</div> --}}
        <div class="total2 bold grayish">{{ number_format($vvlues,0) }}</div>
        @endif
        @endfor
    </div>

<h3 style="font-size:1rem">Term and condition: {{ $hdng3 }}</h3>

    {{-- Footer  --}}
    {{-- <div style="margin-top:64px;"> --}}

        <div style="margin-top:50px;">

            <table class="data" cellspacing="10">
                <tbody>
                    {{ $vvlues = 0 }}
                    @for ($i = 0 ; $i < count($data) ; $i++)
                        @if ($data[$i]->grpid  > 1)
                            <tr>
                                {{ $vvlues += $data[$i]->saleamnt }}
                                <td class="" width="4%">{{ $i+1 }}</td>
                                {{-- <td class="" width="16%">{{ $data[$i]->grpname }} </td> --}}
                                <td class="" width="40%">{{ $data[$i]->matname }} </td>
                                <td style="text-align:center" width="7%">{{ $data[$i]->UOM }} </td>
                                <td style="text-align:left" width="20%">{{ $data[$i]->mybrand }} </td>
                                <td class="" width="9%">{{ number_format($data[$i]->qty,1) }} </td>
                                <td class="" width="9%">{{ number_format($data[$i]->price,1) }} </td>
                                <td style="text-align:right" width="11%">{{ number_format($data[$i]->saleamnt,0) }} </td>

                            </tr>
                        @endif
                    @endfor

                </tbody>

            {{-- </table> --}}




        {{-- </div> --}}





        {{-- <div style="margin-top:750px;"> --}}

        {{-- <table > --}}

            <td style="margin-top:100px;margin-bottom:16px;"></td>
                {{-- <td style="width=33%;font-size:80%;text-align:center">

                </td> --}}

                {{-- <td style="width=33%;font-size:80%;text-align:center">
                    --------------------
                </td> --}}
            </td>
            <tr>
                <td style="width=33%;font-size:80%;text-align:center">
                    Prepared By
                </td>

                <td style="width=33%;font-size:80%;text-align:center">
                    Approved By
                </td>
            </tr>
        </table>
    </div>
    </body>
</html>


