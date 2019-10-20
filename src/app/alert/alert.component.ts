import { Component, OnInit } from '@angular/core';
import { AlertService } from '../services/alert.service';
import { Subscription } from 'rxjs';
@Component({
  selector: 'alert',
  templateUrl: './alert.component.html',
  styleUrls: ['./alert.component.scss']
})
export class AlertComponent implements OnInit {
    private subscription: Subscription;
    message: any;

    constructor(private alertService: AlertService) { }
  ngOnInit() {
          this.subscription = this.alertService.getMessage().subscribe(message => { 
          console.log(message);
            this.message = message; 
        });
  }

}
