<page_footer>   
<table style="width: 100%;margin-bottom: 10px;">
	<tr>
       <td style="width: 50%;">
        <table style="background-color: gray;border: 1px solid black;margin-bottom: 10px;">
         <tr><td style="text-align: right;" >Contractor Acceptance : </td><td style="font-size: 8px">This work has been done as per customer requirement</td></tr>
        <tr>
           <td style="text-align: right;">
            Signature :
           </td>
             <td>
               <img style="height: 10%;" src="{{$sign->contractorcode}}" alt="Contractor Sign">
             </td>
          </tr>
          <tr><td style="text-align: right;">Date : </td><td>{{$sign->contractor_date}}</td></tr>
        </table>  
       </td>
    
       <td style="width: 50%;">
        <table style="background-color: gray;border: 1px solid black;margin-bottom: 10px;">
          <tr><td style="text-align: right;" >Customer Acceptance : </td><td style="font-size: 8px">This work has been done as per our satisfaction</td></tr>
        <tr>
           <td style="text-align: right;">
            Signature :
           </td>
             <td>
               <img style="height: 10%;" src="{{$sign->staffcode}}" alt="Staff Sign">
             </td>
          </tr>
          <tr><td style="text-align: right;">Date : </td><td>{{$sign->staff_date}}</td></tr>
        </table>
       </td>
    </tr>
</table>
</page_footer>