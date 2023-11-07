import app from 'flarum/admin/app';

import ExtensionPage from 'flarum/admin/components/ExtensionPage';
import saveSettings from 'flarum/admin/utils/saveSettings';
import Alert from 'flarum/common/components/Alert';
import Button from 'flarum/common/components/Button';
import Stream from 'flarum/common/utils/Stream';
import { JSONEditor } from 'vanilla-jsoneditor';

export default class SettingsPage extends ExtensionPage {
    oninit(attrs) {
        super.oninit(attrs);
        this.json = app.data.settings['runig006-flarum-affilation.json'] ?? '[{"domain": "amazon.com","params": {"ref": "123456"}}]';
    }
    oncreate(vnode) {
        super.oncreate(vnode);
        if (this.editor != null) {
            return;
        }
        this.editor = new JSONEditor({
            target: document.getElementById('jsoneditor'),
            props: {
                content: {
                    text: this.json
                },
                onChange: (updatedContent, previousContent, { contentErrors, patchResult }) => {
                    if(updatedContent.json){
                        updatedContent = updatedContent.json;
                    }
                    this.json = JSON.stringify(updatedContent).replace(/\\n/g, '');
                }
            }
        })
    }
    content() {
        return (
            <div className="BasicsPage FlarumAffiliation">
                <div className="container"> 
                    <div id="jsoneditor"></div>

                    <Button className={'Button Button--primary'} onclick={() => this.save()}>
                        {app.translator.trans('core.admin.settings.submit_button')}
                    </Button>
                </div>
            </div>
        )
    }
    save() {
        saveSettings({
            "runig006-flarum-affilation.json": this.json,
        }).then(() => {
            app.alerts.show(Alert, { type: 'success' }, app.translator.trans('core.admin.settings.saved_message'));
            m.redraw();
        })
    }
}