import { Component, OnInit } from '@angular/core';
import { AdminService } from '../../services/admin.service';
import { PostService } from 'src/app/services/post.service';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.scss']
})
export class AdminComponent implements OnInit {
  allUsers: any;
  allUsersData: any;
  totalPosts: any;
  totalUsers: any;
  constructor(private admin: AdminService, private postSerice: PostService,private userService:UserService) {
  }

  ngOnInit() {

    this.allUsers = this.admin.getAllUsers().subscribe(
      data => {
        console.log(data);
        this.allUsersData = data;
      },
      error => {
        console.log(error);
      });

    this.postSerice.getTotalPostsByActive().subscribe(
      data => {
        console.log("totalactiveposts", data);
        this.totalPosts = data;
      }
    )

    this.userService.getTotalUsers().subscribe(
      data => {
        console.log("totalusers", data);
        this.totalUsers = data;
      }
    )

  }
}
