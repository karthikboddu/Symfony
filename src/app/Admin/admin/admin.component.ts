import { Component, OnInit } from '@angular/core';
import {AdminService} from '../../services/admin.service';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.scss']
})
export class AdminComponent implements OnInit {
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
