import time

result_aqi = [100,200,300,250,290]
count = 0

def final_aqi(need_cal_aqi, n):
    n = 0
    for i in range (0,5):
        if need_cal_aqi[i] >= 300:
            n += 1
        else:
            continue
    
    if n == 2:
        choosen_value = max(need_cal_aqi) + 50
        return choosen_value 
    elif n >= 3:
        choosen_value = max(need_cal_aqi) + 75
        return choosen_value
    else:
        choosen_value = max(need_cal_aqi)
        return choosen_value


while True:
    a = final_aqi(result_aqi, count)
    
    print a
    time.sleep(1)
    