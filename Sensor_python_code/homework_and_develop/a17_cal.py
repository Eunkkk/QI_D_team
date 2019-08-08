import time

c_values_pm25 = [ [0.0, 12, 0, 50],
                  [12.1, 35.4, 51, 100],
                  [35.5, 55.4, 101, 150],
                  [55.5, 150.4, 151, 200],
                  [150.5, 250.4, 201, 300],
                  [250.5, 350.4, 301, 400],
                  [350.5, 500.4, 401, 500],]


c_values_co = [ [0.0, 4.4, 0, 50],
                [4.5, 9.4, 51, 100],
                [9.5, 12.4, 101, 150],
                [12.5, 15.4, 151, 200],
                [15.5, 30.4, 201, 300],
                [30.5, 40.4, 301, 400],
                [40.5, 50.4, 401, 500],]


c_values_so2 = [[0, 35, 0, 50],
                [36, 75, 51, 100],
                [76, 185, 101, 150],
                [186, 304, 151, 200],
                [305, 604, 201, 300],
                [805, 1004, 401, 500],]
                
                
c_values_no2 = [[0, 53, 0, 50],
                [54, 100, 51, 100],
                [101, 360, 101, 150],
                [361, 649, 151, 200],
                [650, 1249, 201, 300],
                [1250, 1649 ,301, 400],
                [1650, 2049, 401, 500],]


c_values_o3_8hr = [[0, 54, 0, 50],
                   [55, 70, 51, 100],
                   [71, 85, 101, 150],
                   [86, 105, 151, 200],
                   [106, 200, 201, 300],
                   [405, 504 ,301, 400],
                   [505, 604, 401, 500],]
                   
                   
c_values_o3_1hr = [[125, 164, 101, 150],
                   [165, 204, 151, 200],
                   [205, 404, 201, 300],
                   [405, 504 ,301, 400],
                   [505, 604, 401, 500],]
               
                          
def cal_aqi(breakpoints, C):
    Clow = breakpoints[0]
    Chigh = breakpoints[1]
    Ilow = breakpoints[2]
    Ihigh = breakpoints[3]
    aqi = (((Ihigh-Ilow)/(Chigh-Clow))*(C-Clow)) + Ilow
    
    return aqi


def determin_aqi(result_aqi):
    aqi_level = result_aqi
    
    if 0 <= aqi_level <= 50:        return "GOOD"
    elif 51 <= aqi_level <= 100:    return "Moderate"
    elif 101 <= aqi_level <= 150:   return "Unhealthy for Sensitive Groups"
    elif 151 <= aqi_level <= 200:   return "Unhealthy"
    elif 201 <= aqi_level <= 300:   return "Very Unhealthy"
    elif 301 <= aqi_level <= 400:   return "Hazard"
    elif 401 <= aqi_level <= 500:   return "Hazard"
    else:
        if aqi_level < 0: return "Please re-enter."
        else: return "Hazard"
    
    
def bluetooth_communication(send_data):
    for i in range (0,6):
        client_sock.send(str(i) + '-st ' + str(send_data[i]) + '\n')
        if i ==  5:
            client_sock.send('\n')
    time.sleep(5)
    
    
def o3_to_aqi(o3):
    gas=o3
    if gas < 125:
        o3_aqi = 0
    
    elif gas > 604:
        o3_aqi = 500
        
    else:
        for values in c_values_o3_1hr:
            if values[0] <= gas <= values[1]:
                o3_aqi = cal_aqi(values, gas)
    
    return int(o3_aqi)


def co_to_aqi(co):    
    gas=co
    if gas > 50.4:
        co_aqi = 500
    else:
        for values in c_values_co:
            if values[0] <= gas <= values[1]:
                co_aqi = cal_aqi(values, gas)
    
    return int(co_aqi)
    
    
def so2_to_aqi(so2):    
    gas=so2
    if gas > 1004:
        so2_aqi = 500
    else:
        for values in c_values_so2:
            if values[0] <= gas <= values[1]:
                so2_aqi = cal_aqi(values, gas)
    
    return int(so2_aqi)


def no2_to_aqi(no2):   
    gas=no2
    if gas > 2049:
        no2_aqi = 500
    else:
        for values in c_values_no2:
            if values[0] <= gas <= values[1]:
                no2_aqi = cal_aqi(values, gas)
    
    return int(no2_aqi)


def no2_to_aqi(no2):    
    gas=no2
    if gas > 2049:
        no2_aqi = 500
    else:
        for values in c_values_no2:
            if values[0] <= gas <= values[1]:
                no2_aqi = cal_aqi(values, gas)
    
    return int(no2_aqi)
    

def ugm3_to_aqi(ugm3):
    gas=ugm3
    if gas > 500.4:
        pm_aqi = 500
    elif gas < 0:
        return "Please re-enter."
    else:
        for values in c_values_pm25:
            if values[0] <= gas <= values[1]:
                pm_aqi = cal_aqi(values, gas)
    return pm_aqi
    
while True:
    #data = int(raw_input("Select the average data you want"))
    
    data = 35.5
    result = ugm3_to_aqi(data)
    print "\n"
    print int(result)
    b = determin_aqi(result)
    print b
    print "\n"
    
    time.sleep(2)
    