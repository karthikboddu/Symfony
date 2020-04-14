import { Component, OnInit } from '@angular/core';
import { Post } from '../models/post';

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.scss']
})
export class UserComponent implements OnInit {
  postDetails :any;
  constructor() { }

  ngOnInit() {
  }

  loadPostDetails(event:Post[]){
    this.postDetails = event;
    console.log(this.postDetails,"eventemitter");
  }
}
