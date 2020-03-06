import { Component, OnInit, Output, EventEmitter } from '@angular/core';
import { UploadDialogComponent } from '../upload-dialog/upload-dialog.component';
import { MatDialog } from '@angular/material';
import { UploadService } from 'src/app/services/upload.service';

@Component({
  selector: 'app-upload-dashboard',
  templateUrl: './upload-dashboard.component.html',
  styleUrls: ['./upload-dashboard.component.scss']
})
export class UploadDashboardComponent implements OnInit {

  constructor(public dialog: MatDialog, public uploadService: UploadService){

  }
  fileUploadId ;
  @Output() fileAdded = new EventEmitter<{ name: string }>();
  public openUploadDialog() {
    let dialogRef = this.dialog.open(UploadDialogComponent, { width: '50%', height: '50%' });
        dialogRef.afterClosed().subscribe(res => {
         
        console.log(res,"****88");
        this.fileAdded.emit(res);

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
}
