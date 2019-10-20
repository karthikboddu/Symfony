import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AdminViewpostsComponent } from './admin-viewposts.component';

describe('AdminViewpostsComponent', () => {
  let component: AdminViewpostsComponent;
  let fixture: ComponentFixture<AdminViewpostsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AdminViewpostsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AdminViewpostsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
