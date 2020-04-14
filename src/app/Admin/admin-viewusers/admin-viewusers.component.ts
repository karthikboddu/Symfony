import { Component, OnInit } from '@angular/core';
import { AdminService } from 'src/app/services/admin.service';

@Component({
  selector: 'app-admin-viewusers',
  templateUrl: './admin-viewusers.component.html',
  styleUrls: ['./admin-viewusers.component.scss']
})
export class AdminViewusersComponent implements OnInit {

  allUsers:any;
  allUsersData:any;

  constructor(private admin:AdminService) 
  {
  }

  ngOnInit() {
    
    this.allUsers=this.admin.getAllUsers().subscribe(
      data => {
        console.log(data);
        this.allUsersData = data;
      },
      error => {
          console.log(error);
      });
 


}

}
