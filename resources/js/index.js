import addressPickerFormComponent from './components/address-picker';

document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(addressPickerFormComponent);
});

