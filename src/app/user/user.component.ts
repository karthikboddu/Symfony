import { Component, OnInit } from '@angular/core';

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

  loadPostDetails(event){
    this.postDetails = event;
  }
}
