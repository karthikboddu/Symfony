import { Component, OnInit , Input, Output, EventEmitter} from '@angular/core';
import { MatDialog } from '@angular/material';
import { UploadService } from '../services/upload.service';
import { UploadDialogComponent } from './upload-dialog/upload-dialog.component';

@Component({
  selector: 'app-upload',
  templateUrl: './upload.component.html',
  styleUrls: ['./upload.component.scss']
})
export class UploadComponent implements OnInit {

  constructor(public dialog: MatDialog, public uploadService: UploadService) { }


  public openUploadDialog() {
    let dialogRef = this.dialog.open(UploadDialogComponent, { width: '50%', height: '50%' });
        dialogRef.afterClosed().subscribe(res => {
         
        console.log(res,"****88");
    });
  }
  userfiledata : any;
  ngOnInit() {

  	this.uploadService.getFileUpload().subscribe(
        data => {
        	debugger
        	this.userfiledata = data;
          console.log("datasssss", data);
        },
        error => {
          console.log("errors", error);
        });
  }

  // async ngOnDestroy() {
  //   if (this.userfiledata) {
  //       this.userfiledata.unsubscribe();
  //   }

    
  // }

}
