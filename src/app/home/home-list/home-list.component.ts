import { Component, OnInit, Input } from '@angular/core';
import { Post } from 'src/app/models/post';

@Component({
  selector: 'app-home-list',
  templateUrl: './home-list.component.html',
  styleUrls: ['./home-list.component.scss']
})
export class HomeListComponent implements OnInit {

  constructor() { }
  @Input() productDetails: Post[];

  ngOnInit() {
    console.log(this.productDetails,"ddddd");
  }

}
