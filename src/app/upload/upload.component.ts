import { Component, OnInit } from '@angular/core';
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
  }

  ngOnInit() {
  }

}
