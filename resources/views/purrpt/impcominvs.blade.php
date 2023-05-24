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
                    <h1>MUHAMMAD HABIB & Co. </h1>
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
                    <h3 style="font-size:0.7rem">Steam Pipes, Pipe Fittings, Flanges, Valves, S.S.Pipes & Tbues</h3>
                    <h3 style="font-size:0.7rem">30 KM, Sunder Stop, Multan Road, Lahore</h3>
                </td>
            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2.5rem;font-weight: bold">Commercial Invoices</span>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Ledger Info --}}
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
                    Contract Date
                </td>
                <td>
                    {{ $data[0]->contract_date }}
                </td>
            </tr>

            <tr>
                <td>
                    Conversion Rate(x)
                </td>
                <td>
                    {{ $data[0]->conversionrate }}$
                </td>
                <td>
                    Insurance(y)
                </td>
                <td>
                    {{ $data[0]->insurance }}$
                </td>
            </tr>

            <tr>
                <td>
                     Total Invoice Level Expenses(x1)
                </td>
                <td>
                    {{ number_format($data[0]->totherexp,0) }}Rs.
                </td>
                <td>
                    Total Invoice Leve unofficial Expenses(y1)
                </td>
                <td>
                    {{ number_format($data[0]->tuoexp,0) }}$
                </td>
            </tr>
            <tr>
                <td>
                    Supplier Name
                </td>
                <td>
                    {{ $data[0]->supname }}
                </td>
                <td>
                    Invoice No/Date
                </td>
                <td>
                    {{ $data[0]->invoiceno }}  {{ $data[0]->invoice_date }}
                </td>
            </tr>
            {{-- <tr>
                <td>
                    Period
                </td>
                <td>
                    From {{ $fromdate }} to {{ $todate }}
                </td>
                <td>
                    Invoice Date
                </td>
                <td>
                    {{ $data[0]->invoice_date }}
                </td>
            </tr> --}}
        </tbody>
    </table>

    <table class="ledger">
        <tbody>

            <tr>

                <td  style="text-align: center;">
                    <span style="font-size:1rem;font-weight: bold">Supplier Payable Detial</span>
                </td>
            </tr>
        </tbody>
    </table>
    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="" width="3%">S#</th>
                    {{-- <th class="" width="7%">Group</th> --}}
                    <th class="" width="44%">Material Name</th>
                    <th class="" width="4%">Unit</th>
                    <th class="" width="6%">Pcs</th>
                    <th class="" width="6%">Kg</th>
                    <th class="" width="7%">Len/Pc</th>
                    <th class="" width="7%">Feet</th>
                    <th class="" width="7%">Price</th>
                    <th class="" width="8%">Val($)</th>
                    <th class="" width="8%">Val(Rs)</th>

                {{-- </td> --}}
            </tr>
            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="" width="3%"></th>
                    {{-- <th class="" width="7%"></th> --}}
                    <th class="" width="44%"></th>
                    <th class="" width="4%"></th>
                    <th class="" width="6%">a</th>
                    <th class="" width="6%">b</th>
                    <th class="" width="7%">c</th>
                    <th class="" width="7%">d=c*a</th>
                    <th class="" width="7%">e</th>
                    <th class="" width="8%">f=e*b</th>
                    <th class="" width="8%">g=f*x</th>

                {{-- </td> --}}
            </tr>

        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{ $tval = 0 }}
            {{ $tval1 = 0 }}
            {{ $twt = 0 }}
            @for ($i = 0 ; $i < count($data) ; $i++ )
            <tr>
                if ({{ $data[$i]->grp1 }})=1
                {

                        {{ $tval += $data[$i]->amtindollar }}
                        {{ $tval1 += $data[$i]->amtinpkr }}
                        {{ $twt += $data[$i]->gdswt }}
                        <td class="" width="3%">{{ $i+1 }}</td>
                        {{-- <td class="" width="7%">{{ $data[$i]->grp1 }} </td> --}}
                        <td class="" width="44%">{{ $data[$i]->matname }} </td>
                        <td class="" width="4%">{{ $data[$i]->unit }} </td>
                        <td class="" width="6%">{{ number_format($data[$i]->pcs,0) }} </td>
                        <td class="" width="6%">{{ number_format($data[$i]->gdswt,1) }} </td>
                        <td class="" width="7%">{{ number_format($data[$i]->lenperpc,1) }} </td>
                        <td class="" width="7%">{{ number_format($data[$i]->qtyinfeet,0) }} </td>
                        <td class="" width="7%">{{ number_format($data[$i]->gdsprice,2) }} </td>
                        <td class="" width="8%">{{ number_format($data[$i]->amtindollar,0) }} </td>
                        <td class="" width="8%">{{ number_format($data[$i]->amtinpkr,0) }} </td>
                    }
           </tr>
            @endfor

            <tr>
                <td colspan="2" width="60%" style="text-align: right;border-bottom: 1px solid red ;">Total(z)</td>
                <td colspan="3" width="6%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($twt,0) }} </td>
                <td colspan="4" width="8%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tval,0) }} </td>
                <td colspan="1" width="8%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tval1,0) }} </td>

            </tr>

        </tbody>
    </table>
    <table class="ledger">
        <tbody>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:1rem;font-weight: bold">Duty Payable Detial  - I</span>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            <tr>
                    <th style="font-size:10px"; width="3%">S#</th>
                    <th style="font-size:10px"; width="8%">dtyrate</th>
                    <th style="font-size:10px"; width="8%">dtyval</th>
                    <th style="font-size:10px"; width="9%">Ratio(%)</th>
                    <th style="font-size:10px"; width="6%">Ins.($)</th>
                    <th style="font-size:10px"; width="11%">ValWInsu(Rs)</th>
                    <th style="font-size:10px"; width="5%">1%Duty</th>
                    <th style="font-size:10px"; width="5%">CSVal</th>
                    <th style="font-size:10px"; width="5%">CD</th>
                    <th style="font-size:10px"; width="5%">ST</th>
                    <th style="font-size:10px"; width="5%">RD</th>
                    <th style="font-size:10px"; width="5%">ACD</th>
                    <th style="font-size:10px"; width="5%">AST</th>
                    <th style="font-size:10px"; width="5%">IT</th>
                    <th style="font-size:10px"; width="5%">WSE</th>

                {{-- </td> --}}
            </tr>
            <tr>
                <th style="font-size:9px"; width="3%"></th>
                <th style="font-size:9px"; width="8%">e1</th>
                <th style="font-size:9px"; width="8%">g1=e1*b</th>
                <th style="font-size:9px"; width="9%">h=g1/z*100</th>
                <th style="font-size:9px"; width="6%">i=y%h</th>
                <th style="font-size:9px"; width="11%">j=i*x+g</th>
                <th style="font-size:9px"; width="5%">k=j%1</th>
                <th style="font-size:10px"; width="5%">l=j+k</th>
                <th style="font-size:10px"; width="5%">m</th>
                <th style="font-size:10px"; width="5%">n</th>
                <th style="font-size:10px"; width="5%">o</th>
                <th style="font-size:10px"; width="5%">p</th>
                <th style="font-size:10px"; width="5%">q</th>
                <th style="font-size:10px"; width="5%">r</th>
                <th style="font-size:10px"; width="5%">s</th>
            </tr>

        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{ $tvalwi = 0 }}
            {{ $tvalcs = 0 }}
            {{ $tvaldtamt = 0 }}
            {{-- {{ $twt = 0 }} --}}
            @for ($i = 0 ; $i < count($data) ; $i++ )
            <tr>
                if ({{ $data[$i]->grp1 }})=1
                {




                        {{ $tvalwi += $data[$i]->amountwithoutinsurance }}
                        {{ $tvalcs += $data[$i]->pricevaluecostsheet }}
                        {{ $tvaldtamt += $data[$i]->dtyamount }}

                        <td class="" width="3%">{{ $i+1 }}</td>
                        <td class="" width="8%">{{ $data[$i]->dtyrate }} </td>
                        <td class="" width="8%">{{ number_format($data[$i]->dtyamount,0) }} </td>
                        <td class="" width="9%">{{ $data[$i]->itmratio }} </td>
                        <td class="" width="6%">{{ $data[$i]->insuranceperitem }} </td>
                        <td class="" width="15%">{{ number_format($data[$i]->dtyamonthwinsu,0) }} </td>
                        <td class="" width="7%">{{ number_format($data[$i]->oneperduty,0) }} </td>
                        <td class="" width="7%">{{ number_format($data[$i]->costsheetdtyval,0) }} </td>

                        <td class="" width="5%">{{ number_format($data[$i]->cd,2) }} </td>
                        <td class="" width="5%">{{ number_format($data[$i]->st,2) }} </td>
                        <td class="" width="5%">{{ number_format($data[$i]->rd,2) }} </td>
                        <td class="" width="5%">{{ number_format($data[$i]->acd,2) }} </td>
                        <td class="" width="5%">{{ number_format($data[$i]->ast,2) }} </td>
                        <td class="" width="5%">{{ number_format($data[$i]->it,2) }} </td>
                        <td class="" width="5%">{{ number_format($data[$i]->wse,2) }} </td>

                    }
           </tr>
            @endfor

            <tr>
                <td colspan="2" width="8%" style="text-align: right;border-bottom: 1px solid red ;">Total(z)</td>
                <td colspan="1" width="8%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tvaldtamt,0) }} </td>
                <td colspan="3" width="15%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tvalwi,0) }} </td>
                <td colspan="2" width="8%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tvalcs,0) }} </td>
                <td colspan="7" width="61%" style="text-align: right;border-bottom: 1px solid red;">0 </td>

            </tr>

        </tbody>

    </table>


    <table class="ledger">
        <tbody>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:1rem;font-weight: bold">Duty Payable Detial  - II</span>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            <tr>
                    <th class=""  width="3%">S#</th>
                    <th class=""  width="7%">CD</th>
                    <th class=""  width="7%">ST</th>
                    <th class=""  width="7%">RD</th>
                    <th class="" width="7%">ACD</th>
                    <th class="" width="8%">AST</th>
                    <th class="" width="8%">IT</th>
                    <th class="" width="8%">WSE</th>
                    <th class="" width="8%">Total</th>
                    <th class="" width="8%">TotCstWExp</th>
                    <th class="" width="8%">UnOfExpense</th>
                    <th class="" width="7%">PerPc</th>
                    <th class="" width="7%">PerKg</th>
                    <th class="" width="7%">PerFeet</th>

                {{-- </td> --}}
            </tr>
            <tr>
                <th class="" width="3%"></th>
                <th class="" width="7%">t=l%m</th>
                <th class="" width="7%">u=(l+t+v+w)%n</th>
                <th class="" width="7%">v=l%o</th>
                <th class="" width="7%">w=l%p</th>
                <th class="" width="8%">1=(l+t+v+w)%q</th>
                <th class="" width="8%">2=(l+t+u+v+w+1)%r</th>
                <th class="" width="8%">3=l%s</th>
                <th class="" width="8%">4=t-3</th>
                <th class="" width="8%">5=l+4+x1%h</th>
                <th class="" width="8%">6=y1*x%h</th>
                <th class="" width="7%">7=5+6/a</th>
                <th class="" width="7%">8=7/(b/a)</th>
                <th class="" width="7%">9=7/c</th>


            </tr>

        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{ $tvalcd = 0 }}
            {{ $tvalst = 0 }}
            {{ $tvalrd = 0 }}
            {{ $tvalacd = 0 }}
            {{ $tvalasta = 0 }}
            {{ $tvalcdita = 0 }}
            {{ $tvalcdwsca = 0 }}
            {{ $tvalcdtdty = 0 }}
            {{ $tvalcwe = 0 }}
            {{ $tvaluoe = 0 }}

            @for ($i = 0 ; $i < count($data) ; $i++ )
            <tr>
                        {{ $tvalcd += $data[$i]->cda }}
                        {{ $tvalst += $data[$i]->sta }}
                        {{ $tvalrd += $data[$i]->rda }}
                        {{ $tvalacd += $data[$i]->acda }}
                        {{ $tvalasta += $data[$i]->asta }}
                        {{ $tvalcdita += $data[$i]->ita }}
                        {{ $tvalcdwsca += $data[$i]->wsca }}
                        {{ $tvalcdtdty += $data[$i]->tduty }}
                        {{ $tvalcwe += $data[$i]->totcostwexp }}
                        {{ $tvaluoe += $data[$i]->unofficialexp }}

                        <td class="" width="3%">{{ $i+1 }}</td>
                        <td class="" width="7%">{{ number_format($data[$i]->cda,0) }} </td>
                        <td class="" width="7%">{{ number_format($data[$i]->sta,0) }} </td>
                        <td class="" width="7%">{{ number_format($data[$i]->rda,0) }} </td>
                        <td class="" width="7%">{{ number_format($data[$i]->acda,0) }} </td>
                        <td class="" width="8%">{{ number_format($data[$i]->asta,0) }} </td>
                        <td class="" width="8%">{{ number_format($data[$i]->ita,0) }} </td>
                        <td class="" width="8%">{{ number_format($data[$i]->wsca,0) }} </td>
                        <td class="" width="8%">{{ number_format($data[$i]->tduty,0) }} </td>
                        <td class="" width="8%">{{ number_format($data[$i]->totcostwexp,0) }} </td>
                        <td class="" width="8%">{{ number_format($data[$i]->unofficialexp,0) }} </td>
                        <td class="" width="7%">{{ number_format($data[$i]->perpc,2) }} </td>
                        <td class="" width="7%">{{ number_format($data[$i]->perkg,2) }} </td>
                        <td class="" width="7%">{{ number_format($data[$i]->perft,2) }} </td>
           </tr>
            @endfor

            <tr>
                <td colspan="1" width="3%" style="text-align: right;border-bottom: 1px solid red ;">Total</td>
                <td colspan="1" width="7%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tvalcd,0) }} </td>
                <td colspan="1" width="7%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tvalst,0) }} </td>
                <td colspan="1" width="7%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tvalrd,0) }} </td>
                <td colspan="1" width="8%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tvalacd,0) }} </td>
                <td colspan="1" width="8%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tvalasta,0) }} </td>
                <td colspan="1" width="8%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tvalcdwsca,0) }} </td>
                <td colspan="2" width="8%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tvalcdtdty,0) }} </td>
                <td colspan="1" width="8%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tvalcwe,0) }} </td>
                <td colspan="1" width="8%" style="text-align: right;border-bottom: 1px solid red;">{{ number_format($tvaluoe,0) }} </td>
                <td colspan="3" width="28%" style="text-align: right;border-bottom: 1px solid red;"> </td>
            </tr>





        </tbody>


    </table>





    {{-- Footer  --}}
    {{-- <div style="margin-top:64px;">
        <table >

            <tr style="margin-top:16px;margin-bottom:16px;">
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
        </table>
    </div> --}}

    </body>
</html>
