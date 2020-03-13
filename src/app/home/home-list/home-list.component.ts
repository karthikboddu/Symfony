import { Component, OnInit, Input } from '@angular/core';
import { Post } from 'src/app/models/post';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home-list',
  templateUrl: './home-list.component.html',
  styleUrls: ['./home-list.component.scss']
})
export class HomeListComponent implements OnInit {

  constructor(private router:Router) { }
  @Input() productDetails: Post;

  ngOnInit() {
    console.log(this.productDetails.userPost[0].p_id,"ddddd");
  }

  productClick(){
    debugger
    this.router.navigate([{ outlets: { modal: ['post-details', this.productDetails.userPost[0].p_id] } }]);  
  }
  
}
