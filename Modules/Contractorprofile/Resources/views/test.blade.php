
<table style="width: 100%;">
	<tr>
       <td style="width: 50%;background-color: #29dfe8;border-radius: 20;">
       	 <h4 style="width: 100%;text-align: center;">{{ $contractor->company_name }}</h4>
       </td>
    
       <td style="width: 50%;">
       	 <table style="width: 100%;text-align: right;">
       	 	<tr><td style="width: 100%;">{{ $contractor->company_address1 }}</td></tr>
       	 	<tr><td>{{ $contractor->company_address2 }}</td></tr>
          <tr><td>{{ $contractor->company_city }} - {{ $contractor->company_postcode }}</td></tr>
       	 	<tr><td>Phone No. : {{ $contractor->mobile_tel_no }}</td></tr>
       	 	<tr><td>Email : {{ $contractor->company_email }}</td></tr>
       	 </table>
       </td>
    </tr>
</table>

<h3 style="width: 100%;text-align: center;">Service Job Sheet</h3>

<table style="width: 100%;border: 1px solid black;margin-bottom: 10px;">
       <tr>
       <td style="width: 70%;">
               <table style="width: 100%;">
                     <tr><td>Client: </td><td>{{$client->client_name}}</td></tr>
                     <tr><td>Address : </td><td>{{$store->store_name}}</td></tr>
                     <tr><td></td><td>{{$store->address1}}</td></tr>
                     <tr><td></td><td>{{$store->address2}}</td></tr>
                     <tr><td></td><td>{{$store->city}} - {{$store->postcode}}</td></tr>
                     <tr><td>Phone no. : </td><td>{{$contact->phone_no}}</td></tr>
                     <tr><td>Email : </td><td>{{$contact->email}}</td></tr>
               </table>
       </td>
    
       <td style="width: 30%;">
               <table style="width: 100%;text-align: right;">
                     <tr><td>Job Number : </td><td>{{$job->excel_job_number}}</td></tr>
                     <tr><td>Due Date : </td><td>{{$job->due_date}}</td></tr>
                     <tr><td></td><td></td></tr>
                     <tr><td></td><td></td></tr>
                     <tr><td></td><td></td></tr>
                     <tr><td></td><td></td></tr>
               </table>
       </td>
    </tr>
</table>

<table style="width: 100%;border: 1px solid black;margin-bottom: 10px">
       <tr>
       <td style="width: 70%;">
               <table style="width: 100%;text-align: right;">
                     <tr><td>Problem : </td><td>Task1</td></tr>
                     <tr><td></td><td>Task2</td></tr>
                     <tr><td></td><td>Task3</td></tr>
                     <tr><td></td><td></td></tr>
                     <tr><td></td><td></td></tr>
                     <tr><td></td><td></td></tr>
               </table>
       </td>
    
       <td style="width: 30%;">
               <table style="width: 100%;text-align: right;">
                     <tr><td></td><td></td></tr>
                     <tr><td></td><td></td></tr>
                     <tr><td></td><td></td></tr>
                     <tr><td></td><td></td></tr>
               </table>
       </td>
    </tr>
</table>

