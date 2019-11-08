import { Component, OnInit } from '@angular/core';
import { AdminService } from 'src/app/services/admin.service';

@Component({
  selector: 'app-admin-viewposts',
  templateUrl: './admin-viewposts.component.html',
  styleUrls: ['./admin-viewposts.component.scss']
})
export class AdminViewpostsComponent implements OnInit {

  constructor(private adminService : AdminService) { }

  ngOnInit() {
    
  }

}
