import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EstudiantesMeetingRegisterComponent } from './estudiantes-meeting-register.component';

describe('EstudiantesMeetingRegisterComponent', () => {
  let component: EstudiantesMeetingRegisterComponent;
  let fixture: ComponentFixture<EstudiantesMeetingRegisterComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ EstudiantesMeetingRegisterComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(EstudiantesMeetingRegisterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
